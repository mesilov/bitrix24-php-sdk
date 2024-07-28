<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Repository;

use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationInterface;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Exceptions\ApplicationInstallationNotFoundException;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

interface ApplicationInstallationRepositoryInterface
{
    /**
     * Save application installation fact to persistence storage
     */
    public function save(ApplicationInstallationInterface $applicationInstallation): void;

    /**
     * Delete application installation from persistence storage
     *
     * @throws ApplicationInstallationNotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(Uuid $uuid): void;

    /**
     * Get application installation by id
     *
     *
     * @throws ApplicationInstallationNotFoundException
     */
    public function getById(Uuid $uuid): ApplicationInstallationInterface;

    /**
     * Find application installation by bitrix24 account id
     *
     * @return ApplicationInstallationInterface[]
     */
    public function findByBitrix24AccountId(Uuid $uuid): array;

    /**
     * Find application installation by external id
     *
     * @param non-empty-string $externalId
     * @return ApplicationInstallationInterface[]
     * @throws InvalidArgumentException
     */
    public function findByExternalId(string $externalId): array;
}