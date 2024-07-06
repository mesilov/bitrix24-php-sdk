<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequest
{
    public function __construct(protected Request $request)
    {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}