<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Result;

use Bitrix24\SDK\Core\Response\Response;

/**
 * Class AbstractResult
 *
 * @package Bitrix24\SDK\Core\Result
 */
abstract class AbstractResult
{
    protected Response $coreResponse;

    /**
     * AbstractResult constructor.
     *
     * @param Response $coreResponse
     */
    public function __construct(Response $coreResponse)
    {
        $this->coreResponse = $coreResponse;
    }

    /**
     * @return Response
     */
    public function getCoreResponse(): Response
    {
        return $this->coreResponse;
    }
}