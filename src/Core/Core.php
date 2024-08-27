<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Contracts\ApiClientInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\AuthForbiddenException;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\MethodConfirmWaitingException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Events\AuthTokenRenewedEvent;
use Bitrix24\SDK\Events\PortalDomainUrlChangedEvent;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Core implements CoreInterface
{
    public function __construct(
        protected ApiClientInterface       $apiClient,
        protected ApiLevelErrorHandler     $apiLevelErrorHandler,
        protected EventDispatcherInterface $eventDispatcher,
        protected LoggerInterface          $logger)
    {
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function call(string $apiMethod, array $parameters = []): Response
    {
        $this->logger->debug(
            'call.start',
            [
                'method' => $apiMethod,
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
                    $response = new Response($apiCallResponse, new Command($apiMethod, $parameters), $this->apiLevelErrorHandler, $this->logger);
                    break;
                case StatusCodeInterface::STATUS_FOUND:
                    // change domain url
                    $portalOldDomainUrlHost = $this->apiClient->getCredentials()->getDomainUrl();
                    $newDomain = parse_url($apiCallResponse->getHeaders(false)['location'][0]);
                    $portalNewDomainUrlHost = sprintf('%s://%s', $newDomain['scheme'], $newDomain['host']);
                    $this->apiClient->getCredentials()->setDomainUrl($portalNewDomainUrlHost);
                    $this->logger->debug('domain url changed', [
                        'oldDomainUrl' => $portalOldDomainUrlHost,
                        'newDomainUrl' => $portalNewDomainUrlHost,
                    ]);

                    // repeat api-call to new domain url
                    $response = $this->call($apiMethod, $parameters);
                    $this->logger->debug(
                        'api call repeated to new domain url',
                        [
                            'domainUrl' => $portalNewDomainUrlHost,
                            'repeatedApiMethod' => $apiMethod,
                            'httpStatusCode' => $response->getHttpResponse()->getStatusCode(),
                        ]
                    );
                    // dispatch event, application listeners update domain url host in accounts repository
                    $this->eventDispatcher->dispatch(new PortalDomainUrlChangedEvent($portalOldDomainUrlHost, $portalNewDomainUrlHost));
                    break;
                case StatusCodeInterface::STATUS_BAD_REQUEST:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->notice(
                        'bad request',
                        [
                            'rawResponse' => $body,
                        ]
                    );
                    $this->apiLevelErrorHandler->handle($body);
                    break;
                case StatusCodeInterface::STATUS_UNAUTHORIZED:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->debug(
                        'UNAUTHORIZED request',
                        [
                            'rawResponse' => $body,
                        ]
                    );

                    switch (strtolower((string)$body['error'])) {
                        case 'expired_token':
                            // renew access token
                            $renewedToken = $this->apiClient->getNewAuthToken();
                            $this->logger->debug(
                                'access token renewed',
                                [
                                    'newAccessToken' => $renewedToken->authToken->getAccessToken(),
                                    'newRefreshToken' => $renewedToken->authToken->getRefreshToken(),
                                    'newExpires' => $renewedToken->authToken->getExpires(),
                                    'appStatus' => $renewedToken->applicationStatus->getStatusCode(),
                                ]
                            );
                            $this->apiClient->getCredentials()->setAuthToken($renewedToken->authToken);

                            // repeat api-call
                            $response = $this->call($apiMethod, $parameters);
                            $this->logger->debug(
                                'api call repeated',
                                [
                                    'repeatedApiMethod' => $apiMethod,
                                    'httpStatusCode' => $response->getHttpResponse()->getStatusCode(),
                                ]
                            );

                            // dispatch event
                            $this->eventDispatcher->dispatch(new AuthTokenRenewedEvent($renewedToken));
                            break;
                        case 'method_confirm_waiting':
                            throw new MethodConfirmWaitingException(
                                $apiMethod,
                                sprintf('api call method «%s» revoked, waiting confirm from portal administrator', $apiMethod));
                        default:
                            throw new BaseException('UNAUTHORIZED request error');
                    }

                    break;
                case StatusCodeInterface::STATUS_FORBIDDEN:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->warning(
                        'bitrix24 portal authorisation forbidden',
                        [
                            'apiMethod' => $apiMethod,
                            'b24DomainUrl' => $this->apiClient->getCredentials()->getDomainUrl(),
                            'rawResponse' => $body,
                        ]
                    );
                    $this->apiLevelErrorHandler->handle($body);
                    break;
                case StatusCodeInterface::STATUS_SERVICE_UNAVAILABLE:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->notice(
                        'bitrix24 portal unavailable',
                        [
                            'rawResponse' => $body,
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
                            'rawResponse' => $body,
                        ]
                    );
                    $this->apiLevelErrorHandler->handle($body);
                    break;
            }
        } catch (TransportExceptionInterface|JsonException $exception) {
            // catch symfony http client transport exception
            $this->logger->error(
                'call.transportException',
                [
                    'trace' => $exception->getTrace(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw new TransportException(sprintf('transport error - %s, type %s', $exception->getMessage(), $exception::class), $exception->getCode(), $exception);
        } catch (BaseException $exception) {
            // rethrow known bitrix24 php sdk exception
            throw $exception;
        } catch (\Throwable $exception) {
            $this->logger->error(
                'call.unknownException',
                [
                    'message' => $exception->getMessage(),
                    'class' => $exception::class,
                    'trace' => $exception->getTrace(),
                ]
            );
            throw new BaseException(sprintf('unknown error - %s', $exception->getMessage()), $exception->getCode(), $exception);
        }

        $this->logger->debug('call.finish');

        return $response;
    }

    public function getApiClient(): ApiClientInterface
    {
        return $this->apiClient;
    }
}