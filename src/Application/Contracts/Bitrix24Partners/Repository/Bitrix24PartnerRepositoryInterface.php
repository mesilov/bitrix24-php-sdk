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

namespace Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Exceptions\Bitrix24PartnerNotFoundException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

interface Bitrix24PartnerRepositoryInterface
{
    /**
     * Save bitrix24 partner to persistence storage
     * @throws InvalidArgumentException
     */
    public function save(Bitrix24PartnerInterface $bitrix24Partner): void;

    /**
     * Delete bitrix24 partner from persistence storage
     *
     * @throws Bitrix24PartnerNotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(Uuid $uuid): void;

    /**
     * Get bitrix24 partner by id
     *
     * @throws Bitrix24PartnerNotFoundException
     */
    public function getById(Uuid $uuid): Bitrix24PartnerInterface;

    /**
     * Find bitrix24 partner with bitrix24 partner id
     *
     * @param non-negative-int $bitrix24PartnerId
     */
    public function findByBitrix24PartnerId(int $bitrix24PartnerId): ?Bitrix24PartnerInterface;

    /**
     * Find bitrix24 partner by title
     *
     * @param non-empty-string $title
     * @return Bitrix24PartnerInterface[]
     * @throws InvalidArgumentException
     */
    public function findByTitle(string $title): array;

    /**
     * Find bitrix24 partner by external id
     *
     * External id its id in external system (erp/crm) its company id or smart-process item id
     *
     * @param non-empty-string $externalId
     * @return Bitrix24PartnerInterface[]
     * @throws InvalidArgumentException
     */
    public function findByExternalId(string $externalId, ?Bitrix24PartnerStatus $bitrix24PartnerStatus = null): array;
}