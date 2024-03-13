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
     * Generic method to find duplicates by communication type.
     * 
     * @link https://training.bitrix24.com/rest_help/crm/auxiliary/duplicates/crm.duplicate.findbycomm.php
     * @param string $type 'PHONE' or 'EMAIL'
     * @param array<string> $values Array containing up to 20 phone numbers or emails
     * @param EntityType|null $entityType Can be skipped: all three entity types will be returned in this case. If this parameter is used, you can operate only with one of them. If you specify an array or non-existent parameter, all entity types will be returned.
     * @return DuplicateResult
     * @throws BaseException
     * @throws TransportException
     */
    private function findByCommType(string $type, array $values, ?EntityType $entityType = null): DuplicateResult
    {
        $response = $this->core->call('crm.duplicate.findbycomm', [
            'type' => $type,
            'values' => $values,
            'entity_type' => $entityType?->value
        ]);

        return new DuplicateResult($response);
    }

    public function findByPhone(array $phones, ?EntityType $entityType): DuplicateResult
    {
        return $this->findByCommType('PHONE', $phones, $entityType);
    }

    public function findByEmail(array $emails, ?EntityType $entityType): DuplicateResult
    {
        return $this->findByCommType('EMAIL', $emails, $entityType);
    }
}