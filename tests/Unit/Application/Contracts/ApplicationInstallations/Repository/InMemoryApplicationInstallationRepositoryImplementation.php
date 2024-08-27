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

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ApplicationInstallations\Repository;

use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationInterface;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity\ApplicationInstallationStatus;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Exceptions\ApplicationInstallationNotFoundException;
use Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Repository\ApplicationInstallationRepositoryInterface;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

class InMemoryApplicationInstallationRepositoryImplementation implements ApplicationInstallationRepositoryInterface
{
    /**
     * @var ApplicationInstallationInterface[]
     */
    private array $items = [];

    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }

    public function save(ApplicationInstallationInterface $applicationInstallation): void
    {
        $this->logger->debug('InMemoryApplicationInstallationRepositoryImplementation.save', ['id' => $applicationInstallation->getId()->toRfc4122()]);

        $this->items[$applicationInstallation->getId()->toRfc4122()] = $applicationInstallation;
    }

    public function delete(Uuid $uuid): void
    {
        $this->logger->debug('InMemoryApplicationInstallationRepositoryImplementation.delete', ['id' => $uuid->toRfc4122()]);

        $applicationInstallation = $this->getById($uuid);
        if (ApplicationInstallationStatus::deleted !== $applicationInstallation->getStatus()) {
            throw new InvalidArgumentException(sprintf('you cannot delete application installation «%s», in status «%s», mark applicatoin installation as «deleted» before',
                $applicationInstallation->getId()->toRfc4122(),
                $applicationInstallation->getStatus()->name,
            ));
        }

        unset($this->items[$uuid->toRfc4122()]);
    }

    public function getById(Uuid $uuid): ApplicationInstallationInterface
    {
        $this->logger->debug('InMemoryApplicationInstallationRepositoryImplementation.getById', ['id' => $uuid->toRfc4122()]);

        if (!array_key_exists($uuid->toRfc4122(), $this->items)) {
            throw new ApplicationInstallationNotFoundException(sprintf('application installation not found by id «%s» ', $uuid->toRfc4122()));
        }

        return $this->items[$uuid->toRfc4122()];
    }

    public function findByBitrix24AccountId(Uuid $uuid): array
    {
        $this->logger->debug('InMemoryApplicationInstallationRepositoryImplementation.findByBitrix24AccountId', ['id' => $uuid->toRfc4122()]);

        $result = [];
        foreach ($this->items as $item) {
            if ($item->getBitrix24AccountId() === $uuid) {
                $result[] = $item;
            }
        }

        return $result;
    }

    public function findByExternalId(string $externalId): array
    {
        $this->logger->debug('InMemoryApplicationInstallationRepositoryImplementation.findByExternalId', ['externalId' => $externalId]);
        if (trim($externalId) === '') {
            throw new InvalidArgumentException('external id cannot be empty string');
        }

        $result = [];
        foreach ($this->items as $item) {
            if ($item->getExternalId() === $externalId) {
                $result[] = $item;
            }
        }

        return $result;
    }
}