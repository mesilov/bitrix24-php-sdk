<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Commands\Command;
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
class Core
{
    /**
     * @var ApiClient
     */
    protected $apiClient;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Main constructor.
     *
     * @param ApiClient                $apiClient
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface          $logger
     */
    public function __construct(ApiClient $apiClient, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->apiClient = $apiClient;
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
            }
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error(
                'call.transportException',
                [
                    'trace'   => $exception->getTrace(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw new TransportException(sprintf('transport error - %s', $exception->getMessage()), $exception->getCode(), $exception);
        } catch (\Throwable $exception) {
            $this->logger->error(
                'call.unknownException',
                [
                    'message' => $exception->getMessage(),
                ]
            );
            throw new BaseException(sprintf('unknown error - %s', $exception->getMessage()), $exception->getCode(), $exception);
        }
        $this->logger->debug('call.finish');

        return $response;
    }
}