<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Accounts\Repository;


use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Exceptions\Bitrix24AccountNotFoundException;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Repository\Bitrix24AccountRepositoryInterface;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

class InMemoryBitrix24AccountRepositoryImplementation implements Bitrix24AccountRepositoryInterface
{
    /**
     * @var Bitrix24AccountInterface[]
     */
    private array $items = [];

    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }

    public function save(Bitrix24AccountInterface $bitrix24Account): void
    {
        $this->logger->debug('b24AccountRepository.save', ['id' => $bitrix24Account->getId()->toRfc4122()]);

        $this->items[$bitrix24Account->getId()->toRfc4122()] = $bitrix24Account;
    }

    public function delete(Uuid $uuid): void
    {
        $this->logger->debug('b24AccountRepository.delete', ['id' => $uuid->toRfc4122()]);

        $item = $this->getById($uuid);
        if (Bitrix24AccountStatus::deleted !== $item->getStatus()) {
            throw new InvalidArgumentException(sprintf('you cannot delete bitrix24account «%s», they must be in status deleted, current status «%s»',
                $item->getId()->toRfc4122(),
                $item->getStatus()->name
            ));
        }
        unset($this->items[$uuid->toRfc4122()]);
    }

    public function getById(Uuid $uuid): Bitrix24AccountInterface
    {
        $this->logger->debug('b24AccountRepository.getById', ['id' => $uuid->toRfc4122()]);

        if (!array_key_exists($uuid->toRfc4122(), $this->items)) {
            throw new Bitrix24AccountNotFoundException(sprintf('bitrix24 account not found for id «%s» ', $uuid->toRfc4122()));
        }
        return $this->items[$uuid->toRfc4122()];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findOneAdminByMemberId(string $memberId): ?Bitrix24AccountInterface
    {
        $this->logger->debug('b24AccountRepository.findOneAdminByMemberId', ['memberId' => $memberId]);

        if ($memberId === '') {
            throw new InvalidArgumentException('memberId cannot be empty');
        }

        foreach ($this->items as $item) {
            if ($item->getMemberId() === $memberId && $item->isBitrix24UserAdmin()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findByMemberId(string $memberId, ?Bitrix24AccountStatus $status = null, ?bool $isAdmin = null): array
    {
        $this->logger->debug('b24AccountRepository.findByMemberId', [
            'memberId' => $memberId,
            'status' => $status?->name,
            'isAdmin' => $isAdmin
        ]);

        if ($memberId === '') {
            throw new InvalidArgumentException('memberId cannot be empty');
        }

        $items = [];
        foreach ($this->items as $item) {
            if ($item->getMemberId() !== $memberId) {
                continue;
            }

            $isStatusMatch = ($status === null || $status === $item->getStatus());
            $isAdminMatch = ($isAdmin === null || $isAdmin === $item->isBitrix24UserAdmin());

            if ($isStatusMatch && $isAdminMatch) {
                $items[] = $item;
            }

        }
        return $items;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findByDomain(string $domainUrl, ?Bitrix24AccountStatus $status = null, ?bool $isAdmin = null): array
    {
        $this->logger->debug('b24AccountRepository.findByDomain', [
            'domain' => $domainUrl,
            'status' => $status?->name,
            'isAdmin' => $isAdmin
        ]);

        if ($domainUrl === '') {
            throw new InvalidArgumentException('domain url cannot be empty');
        }

        $items = [];
        foreach ($this->items as $item) {
            if ($item->getDomainUrl() !== $domainUrl) {
                continue;
            }

            $isStatusMatch = ($status === null || $status === $item->getStatus());
            $isAdminMatch = ($isAdmin === null || $isAdmin === $item->isBitrix24UserAdmin());

            if ($isStatusMatch && $isAdminMatch) {
                $items[] = $item;
            }

        }
        return $items;
    }
}