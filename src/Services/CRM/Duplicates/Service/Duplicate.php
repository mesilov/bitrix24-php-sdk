<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Duplicates\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Duplicates\Result\DuplicateResult;

#[ApiServiceMetadata(new Scope(['crm']))]
class Duplicate extends AbstractService
{
    /**
     * @param array<string> $phones
     * @param EntityType|null $entityType
     * @return DuplicateResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.duplicate.findbycomm',
        'https://training.bitrix24.com/rest_help/crm/auxiliary/duplicates/crm.duplicate.findbycomm.php',
        'The method returns IDs for leads, contacts or companies that contain the specified phone numbers or e-mails.'
    )]
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
    #[ApiEndpointMetadata(
        'crm.duplicate.findbycomm',
        'https://training.bitrix24.com/rest_help/crm/auxiliary/duplicates/crm.duplicate.findbycomm.php',
        'The method returns IDs for leads, contacts or companies that contain the specified phone numbers or e-mails.'
    )]
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