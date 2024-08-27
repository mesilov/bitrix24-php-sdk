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

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Partners\Repository;

use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Exceptions\Bitrix24PartnerNotFoundException;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Repository\Bitrix24PartnerRepositoryInterface;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

class InMemoryBitrix24PartnerRepositoryImplementation implements Bitrix24PartnerRepositoryInterface
{
    /**
     * @var Bitrix24PartnerInterface[]
     */
    private array $items = [];

    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }

    public function findByBitrix24PartnerId(int $bitrix24PartnerId): ?Bitrix24PartnerInterface
    {
        $this->logger->debug('b24PartnerRepository.findByBitrix24PartnerId', [
            'bitrix24PartnerId' => $bitrix24PartnerId
        ]);

        foreach ($this->items as $item) {
            if ($item->getBitrix24PartnerId() === $bitrix24PartnerId) {
                $this->logger->debug('b24PartnerRepository.findByBitrix24PartnerId.found', [
                    'id' => $item->getId()->toRfc4122()
                ]);
                return $item;
            }
        }

        return null;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findByTitle(string $title): array
    {
        $this->logger->debug('b24PartnerRepository.findByTitle', [
            'title' => $title
        ]);

        if (trim($title) === '') {
            throw new InvalidArgumentException('you cant find by empty title');
        }

        $title = strtolower(trim($title));

        $items = [];
        foreach ($this->items as $item) {
            if (strtolower($item->getTitle()) === $title) {
                $this->logger->debug('b24PartnerRepository.findByTitle.found', [
                    'id' => $item->getId()->toRfc4122()
                ]);
                $items[] = $item;
            }
        }

        return $items;
    }

    public function findByExternalId(string $externalId, ?Bitrix24PartnerStatus $bitrix24PartnerStatus = null): array
    {
        $this->logger->debug('b24PartnerRepository.findByExternalId', [
            'externalId' => $externalId,
            'bitrix24PartnerStatus' => $bitrix24PartnerStatus?->name
        ]);

        if (trim($externalId) === '') {
            throw new InvalidArgumentException('you cant find by empty externalId');
        }

        $externalId = trim($externalId);

        $items = [];
        foreach ($this->items as $item) {
            if ($item->getExternalId() === $externalId && (is_null($bitrix24PartnerStatus) || $item->getStatus() === $bitrix24PartnerStatus)) {
                $this->logger->debug('b24PartnerRepository.findByExternalId.found', [
                    'id' => $item->getId()->toRfc4122()
                ]);
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function save(Bitrix24PartnerInterface $bitrix24Partner): void
    {
        $this->logger->debug('b24PartnerRepository.save', [
            'id' => $bitrix24Partner->getId()->toRfc4122(),
            'bitrix24PartnerId' => $bitrix24Partner->getBitrix24PartnerId()
        ]);

        if ($bitrix24Partner->getBitrix24PartnerId() === null) {
            $this->items[$bitrix24Partner->getId()->toRfc4122()] = $bitrix24Partner;
            return;
        }

        $existsPartner = $this->findByBitrix24PartnerId($bitrix24Partner->getBitrix24PartnerId());
        if ($existsPartner instanceof Bitrix24PartnerInterface && $existsPartner->getId() !== $bitrix24Partner->getId()) {
            throw new InvalidArgumentException(sprintf(
                'bitrix24 partner «%s» with bitrix24 partner id is «%s» already exists with id «%s» in status «%s»',
                $existsPartner->getTitle(),
                $bitrix24Partner->getBitrix24PartnerId(),
                $existsPartner->getId(),
                $existsPartner->getStatus()->name
            ));
        }

        $this->items[$bitrix24Partner->getId()->toRfc4122()] = $bitrix24Partner;
    }

    public function delete(Uuid $uuid): void
    {
        $this->logger->debug('b24PartnerRepository.delete', ['id' => $uuid->toRfc4122()]);

        $bitrix24Partner = $this->getById($uuid);
        if (Bitrix24PartnerStatus::deleted !== $bitrix24Partner->getStatus()) {
            throw new InvalidArgumentException(sprintf('you cannot delete bitrix24 partner item «%s», they must be in status deleted, current status «%s»',
                $bitrix24Partner->getId()->toRfc4122(),
                $bitrix24Partner->getStatus()->name
            ));
        }

        unset($this->items[$uuid->toRfc4122()]);
    }

    public function getById(Uuid $uuid): Bitrix24PartnerInterface
    {
        $this->logger->debug('b24PartnerRepository.getById', ['id' => $uuid->toRfc4122()]);

        if (!array_key_exists($uuid->toRfc4122(), $this->items)) {
            throw new Bitrix24PartnerNotFoundException(sprintf('bitrix24 partner not found by id «%s» ', $uuid->toRfc4122()));
        }

        return $this->items[$uuid->toRfc4122()];
    }
}