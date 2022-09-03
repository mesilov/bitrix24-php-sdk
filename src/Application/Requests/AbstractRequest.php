<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequest
{
    protected Request $request;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}