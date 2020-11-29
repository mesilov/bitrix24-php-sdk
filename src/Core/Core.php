<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Events\AuthTokenRenewedEvent;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

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
    protected $log;
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Main constructor.
     *
     * @param ApiClient                $apiClient
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface          $log
     */
    public function __construct(ApiClient $apiClient, EventDispatcherInterface $eventDispatcher, LoggerInterface $log)
    {
        $this->apiClient = $apiClient;
        $this->eventDispatcher = $eventDispatcher;
        $this->log = $log;
    }

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return Response
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \JsonException
     * @throws BaseException
     */
    public function call(string $apiMethod, array $parameters = []): Response
    {
        $this->log->debug(
            'call.start',
            [
                'method'     => $apiMethod,
                'parameters' => $parameters,
            ]
        );

        // make async request
        $apiCallResponse = $this->apiClient->getResponse($apiMethod, $parameters);

        $response = null;
        switch ($apiCallResponse->getStatusCode()) {
            case StatusCodeInterface::STATUS_OK:
                //todo check with empty response size from server
                $response = new Response($apiCallResponse, new Command($apiMethod, $parameters), $this->log);
                break;
            case StatusCodeInterface::STATUS_UNAUTHORIZED:
                $body = $apiCallResponse->toArray(false);
                $this->log->notice(
                    'UNAUTHORIZED request',
                    [
                        'body' => $body,
                    ]
                );

                if ($body['error'] === 'expired_token') {
                    // renew access token
                    $renewedToken = $this->apiClient->getNewAccessToken();
                    $this->log->debug(
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
                    $this->log->debug(
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
        $this->log->debug('call.finish');

        return $response;
    }
}