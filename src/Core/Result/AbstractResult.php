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
    /**
     * AbstractResult constructor.
     */
    public function __construct(protected Response $coreResponse)
    {
    }

    public function getCoreResponse(): Response
    {
        return $this->coreResponse;
    }
}