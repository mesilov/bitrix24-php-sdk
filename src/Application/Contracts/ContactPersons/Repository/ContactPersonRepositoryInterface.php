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

namespace Bitrix24\SDK\Application\Contracts\ContactPersons\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Exceptions\ContactPersonNotFoundException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use libphonenumber\PhoneNumber;
use Symfony\Component\Uid\Uuid;

interface ContactPersonRepositoryInterface
{
    /**
     * Save contact person to persistence storage
     */
    public function save(ContactPersonInterface $contactPerson): void;

    /**
     * Delete contact person from persistence storage
     * @throws ContactPersonNotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(Uuid $uuid): void;

    /**
     * Get contact person by id
     * @throws ContactPersonNotFoundException
     */
    public function getById(Uuid $uuid): ContactPersonInterface;

    /**
     * Find contact persons with email and filter by status and isEmailVerified flag
     * @param non-empty-string $email
     * @return ContactPersonInterface[]
     */
    public function findByEmail(string $email, ?ContactPersonStatus $contactPersonStatus = null, ?bool $isEmailVerified = null): array;

    /**
     * Find contact persons with PhoneNumber and filter by status and isEmailVerified flag
     * @return ContactPersonInterface[]
     */
    public function findByPhone(PhoneNumber $phoneNumber, ?ContactPersonStatus $contactPersonStatus = null, ?bool $isPhoneVerified = null): array;

    /**
     * Find contact person by external id
     *
     * One contact person can install application in different portals in different times, but in external system (erp/crm) its only one contact
     *
     * @param non-empty-string $externalId
     * @return ContactPersonInterface[]
     * @throws InvalidArgumentException
     */
    public function findByExternalId(string $externalId, ?ContactPersonStatus $contactPersonStatus = null): array;
}