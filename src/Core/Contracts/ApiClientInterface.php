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

namespace Bitrix24\SDK\Core\Contracts;

use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiClientInterface
{
    /**
     * @throws TransportExceptionInterface
     * @throws InvalidArgumentException
     */
    public function getResponse(string $apiMethod, array $parameters = []): ResponseInterface;

    /**
     * @throws InvalidArgumentException
     * @throws TransportExceptionInterface
     */
    public function getNewAuthToken(): RenewedAuthToken;

    public function getCredentials(): Credentials;
}