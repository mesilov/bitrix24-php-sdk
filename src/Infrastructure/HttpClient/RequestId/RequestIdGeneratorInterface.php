<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Infrastructure\HttpClient\RequestId;

interface RequestIdGeneratorInterface
{
    public function getRequestId(): string;

    public function getHeaderFieldName(): string;

    public function getQueryStringParameterName():string;
}