<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Contracts\ApiClientInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Events\AuthTokenRenewedEvent;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class Core
 *
 * @package Bitrix24\SDK\Core
 */
class Core implements CoreInterface
{
    protected ApiClientInterface $apiClient;
    protected LoggerInterface $logger;
    protected EventDispatcherInterface $eventDispatcher;
    protected ApiLevelErrorHandler $apiLevelErrorHandler;

    /**
     * Main constructor.
     *
     * @param ApiClientInterface       $apiClient
     * @param ApiLevelErrorHandler     $apiLevelErrorHandler
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface          $logger
     */
    public function __construct(
        ApiClientInterface $apiClient,
        ApiLevelErrorHandler $apiLevelErrorHandler,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->apiClient = $apiClient;
        $this->apiLevelErrorHandler = $apiLevelErrorHandler;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function call(string $apiMethod, array $parameters = []): Response
    {
        $this->logger->debug(
            'call.start',
            [
                'method'     => $apiMethod,
                'parameters' => $parameters,
            ]
        );

        $response = null;
        try {
            // make async request
            $apiCallResponse = $this->apiClient->getResponse($apiMethod, $parameters);
            $this->logger->debug(
                'call.responseInfo',
                [
                    'httpStatus' => $apiCallResponse->getStatusCode(),
                ]
            );
            switch ($apiCallResponse->getStatusCode()) {
                case StatusCodeInterface::STATUS_OK:
                    //todo check with empty response size from server
                    $response = new Response($apiCallResponse, new Command($apiMethod, $parameters), $this->logger);
                    break;
                case StatusCodeInterface::STATUS_UNAUTHORIZED:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->notice(
                        'UNAUTHORIZED request',
                        [
                            'body' => $body,
                        ]
                    );

                    if ($body['error'] === 'expired_token') {
                        // renew access token
                        $renewedToken = $this->apiClient->getNewAccessToken();
                        $this->logger->debug(
                            'access token renewed',
                            [
                                'newAccessToken'  => $renewedToken->getAccessToken()->getAccessToken(),
                                'newRefreshToken' => $renewedToken->getAccessToken()->getRefreshToken(),
                                'newExpires'      => $renewedToken->getAccessToken()->getExpires(),
                                'appStatus'       => $renewedToken->getApplicationStatus(),
                            ]
                        );
                        $this->apiClient->getCredentials()->setAccessToken($renewedToken->getAccessToken());

                        // repeat api-call
                        $response = $this->call($apiMethod, $parameters);
                        $this->logger->debug(
                            'api call repeated',
                            [
                                'repeatedApiMethod' => $apiMethod,
                                'httpStatusCode'    => $response->getHttpResponse()->getStatusCode(),
                            ]
                        );

                        // dispatch event
                        $this->eventDispatcher->dispatch(new AuthTokenRenewedEvent($renewedToken));
                    } else {
                        throw new BaseException('UNAUTHORIZED request error');
                    }
                    break;
                case StatusCodeInterface::STATUS_SERVICE_UNAVAILABLE:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->notice(
                        'bitrix24 portal unavailable',
                        [
                            'body' => $body,
                        ]
                    );
                    $this->apiLevelErrorHandler->handle($body);
                    break;
                default:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->notice(
                        'unhandled server status',
                        [
                            'httpStatus' => $apiCallResponse->getStatusCode(),
                            'body'       => $body,
                        ]
                    );
                    $this->apiLevelErrorHandler->handle($body);
                    break;
            }
        } catch (TransportExceptionInterface $exception) {
            // catch symfony http client transport exception
            $this->logger->error(
                'call.transportException',
                [
                    'trace'   => $exception->getTrace(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw new TransportException(sprintf('transport error - %s', $exception->getMessage()), $exception->getCode(), $exception);
        } catch (BaseException $exception) {
            // rethrow known bitrix24 php sdk exception
            throw $exception;
        } catch (\Throwable $exception) {
            $this->logger->error(
                'call.unknownException',
                [
                    'message' => $exception->getMessage(),
                    'trace'   => $exception->getTrace(),
                ]
            );
            throw new BaseException(sprintf('unknown error - %s', $exception->getMessage()), $exception->getCode(), $exception);
        }
        $this->logger->debug('call.finish');

        return $response;
    }

    /**
     * @return \Bitrix24\SDK\Core\Contracts\ApiClientInterface
     */
    public function getApiClient(): ApiClientInterface
    {
        return $this->apiClient;
    }
}