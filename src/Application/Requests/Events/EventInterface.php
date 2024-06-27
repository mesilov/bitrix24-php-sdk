<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events;


use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Bitrix24\SDK\Core\Result\AbstractItem;

interface EventInterface
{
    public function getEventCode(): string;

    public function getAuth(): EventAuthItem;

    public function getEventPayload(): array;
}