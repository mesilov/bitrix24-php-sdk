<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Duplicates\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Duplicates\Result\DuplicateResult;

class Duplicate extends AbstractService
{
    /**
     * @param array<string> $phones
     * @param EntityType|null $entityType
     * @return DuplicateResult
     * @throws BaseException
     * @throws TransportException
     */
    public function findByPhone(array $phones, ?EntityType $entityType = null): mixed
    {
        return new DuplicateResult($this->core->call('crm.duplicate.findbycomm',
            [
                'type' => 'PHONE',
                'values' => $phones,
                'entity_type' => $entityType?->value
            ]));
    }

    /**
     * @param array<string> $emails
     * @param EntityType|null $entityType
     * @return DuplicateResult
     * @throws BaseException
     * @throws TransportException
     */
    public function findByEmail(array $emails, ?EntityType $entityType = null): DuplicateResult
    {
        return new DuplicateResult($this->core->call('crm.duplicate.findbycomm',
            [
                'type' => 'EMAIL',
                'values' => $emails,
                'entity_type' => $entityType?->value
            ]));
    }
}