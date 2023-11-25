<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Infrastructure\HttpClient\RequestId;

use Symfony\Component\Uid\Uuid;

class DefaultRequestIdGenerator implements RequestIdGeneratorInterface
{
    public function getRequestId(): string
    {
        // get from  server fields
        // if empty - generate
        return Uuid::v7()->toRfc4122();
    }

    public function getHeaderFieldName(): string
    {
        return 'X-Request-ID';
    }
}