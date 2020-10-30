<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Core\ApiClient;
use Bitrix24\SDK\Core\Response\Response;
use Psr\Log\LoggerInterface;

/**
 * Class Main
 *
 * @package Bitrix24\SDK\Services
 */
class Main
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
     * Main constructor.
     *
     * @param ApiClient       $apiClient
     * @param LoggerInterface $log
     */
    public function __construct(ApiClient $apiClient, LoggerInterface $log)
    {
        $this->apiClient = $apiClient;
        $this->log = $log;
    }

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function call(string $apiMethod, array $parameters = []): Response
    {
        $result = $this->apiClient->getResponse($apiMethod, $parameters);

        return new Response($result, $this->log);
    }
}