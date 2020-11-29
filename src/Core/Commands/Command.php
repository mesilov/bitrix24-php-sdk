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
    /**
     * @var string
     */
    private $apiMethod;
    /**
     * @var array
     */
    private $parameters;
    /**
     * @var null|string
     */
    private $name;
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * BatchCommand constructor.
     *
     * @param string      $apiMethod
     * @param array       $parameters
     * @param string|null $name
     *
     * @throws \Exception
     */
    public function __construct(string $apiMethod, array $parameters, ?string $name = null)
    {
        $this->uuid = Uuid::uuid4();
        $this->apiMethod = $apiMethod;
        $this->parameters = $parameters;
        $this->name = $name ?? $this->uuid->toString();
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getApiMethod(): string
    {
        return $this->apiMethod;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
