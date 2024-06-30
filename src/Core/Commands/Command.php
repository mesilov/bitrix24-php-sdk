<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Commands;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Command
 *
 * @package Bitrix24\SDK\Core\Commands
 */
class Command
{
    private readonly string $name;

    private readonly \Ramsey\Uuid\UuidInterface $uuid;

    /**
     * BatchCommand constructor.
     *
     *
     * @throws \Exception
     */
    public function __construct(private readonly string $apiMethod, private readonly array $parameters, ?string $name = null)
    {
        $this->uuid = Uuid::uuid4();
        $this->name = $name ?? $this->uuid->toString();
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getApiMethod(): string
    {
        return $this->apiMethod;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
