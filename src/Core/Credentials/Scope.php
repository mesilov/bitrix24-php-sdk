<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

/**
 * Class Scope
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class Scope
{
    public function __construct()
    {
    }

    public function withCrm(): self
    {
        return $this;
    }


    public function build(): array
    {
        return [];
    }
}