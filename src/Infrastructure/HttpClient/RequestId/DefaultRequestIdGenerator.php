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

namespace Bitrix24\SDK\Infrastructure\HttpClient\RequestId;

use Symfony\Component\Uid\Uuid;

class DefaultRequestIdGenerator implements RequestIdGeneratorInterface
{
    private const DEFAULT_REQUEST_ID_HEADER_FIELD_NAME = 'X-Request-ID';
    private const DEFAULT_QUERY_STRING_PARAMETER_NAME = 'bx24_request_id';
    private const KEY_NAME_VARIANTS = [
        'REQUEST_ID',
        'HTTP_X_REQUEST_ID',
        'UNIQUE_ID'
    ];

    public function getQueryStringParameterName(): string
    {
        return self::DEFAULT_QUERY_STRING_PARAMETER_NAME;
    }


    private function generate(): string
    {
        return Uuid::v7()->toRfc4122();
    }

    private function findExists(): ?string
    {
        $candidate = null;
        foreach (self::KEY_NAME_VARIANTS as $key) {
            if (!empty($_SERVER[$key])) {
                $candidate = $_SERVER[$key];
                break;
            }
        }
        return $candidate;
    }

    public function getRequestId(): string
    {
        $reqId = $this->findExists();
        if ($reqId === null) {
            $reqId = $this->generate();
        }
        return $reqId;
    }

    public function getHeaderFieldName(): string
    {
        return self::DEFAULT_REQUEST_ID_HEADER_FIELD_NAME;
    }
}