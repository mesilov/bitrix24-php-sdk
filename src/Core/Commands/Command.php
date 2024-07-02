<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Commands;

use Symfony\Component\Uid\Uuid;

class Command
{
    public function __construct(
        private readonly string $apiMethod,
        private readonly array  $parameters,
        private ?string         $id = null)
    {
        if ($id === null) {
            $this->id = (Uuid::v7())->toRfc4122();
        }
    }

    public function getApiMethod(): string
    {
        return $this->apiMethod;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
