<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Contracts;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;

/**
 * Interface CoreInterface
 *
 * @package Bitrix24\SDK\Core\Contracts
 */
interface CoreInterface
{
    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function call(string $apiMethod, array $parameters = []): Response;

    public function getApiClient(): ApiClientInterface;
}