<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\ContactPersons\Repository;

use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonInterface;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Exceptions\ContactPersonNotFoundException;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Repository\ContactPersonRepositoryInterface;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use libphonenumber\PhoneNumber;


class InMemoryContactPersonRepositoryImplementation implements ContactPersonRepositoryInterface
{
    /**
     * @var ContactPersonInterface[]
     */
    private array $items = [];

    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }

    public function save(ContactPersonInterface $contactPerson): void
    {
        $this->logger->debug('InMemoryContactPersonRepositoryImplementation.save', ['id' => $contactPerson->getId()->toRfc4122()]);

        $this->items[$contactPerson->getId()->toRfc4122()] = $contactPerson;
    }

    public function delete(Uuid $uuid): void
    {
        $this->logger->debug('InMemoryContactPersonRepositoryImplementation.delete', ['id' => $uuid->toRfc4122()]);

        $contactPerson = $this->getById($uuid);
        if (ContactPersonStatus::deleted !== $contactPerson->getStatus()) {
            throw new InvalidArgumentException(sprintf('you cannot delete contact person «%s», in status «%s», mark contact person as deleted before',
                $contactPerson->getId()->toRfc4122(),
                $contactPerson->getStatus()->name,
            ));
        }

        unset($this->items[$uuid->toRfc4122()]);
    }

    /**
     * @throws ContactPersonNotFoundException
     */
    public function getById(Uuid $uuid): ContactPersonInterface
    {
        $this->logger->debug('InMemoryContactPersonRepositoryImplementation.getById', ['id' => $uuid->toRfc4122()]);

        if (!array_key_exists($uuid->toRfc4122(), $this->items)) {
            throw new ContactPersonNotFoundException(sprintf('contact person not found by id «%s» ', $uuid->toRfc4122()));
        }

        return $this->items[$uuid->toRfc4122()];
    }

    public function findByEmail(string $email, ?ContactPersonStatus $contactPersonStatus = null, ?bool $isEmailVerified = null): array
    {
        $result = [];
        foreach ($this->items as $item) {
            if ($email !== $item->getEmail()) {
                continue;
            }

            if ($contactPersonStatus instanceof ContactPersonStatus && $contactPersonStatus !== $item->getStatus()) {
                continue;
            }

            if ($isEmailVerified !== null && $isEmailVerified !== ($item->getEmailVerifiedAt() !== null)) {
                continue;
            }

            $result[] = $item;
        }

        return $result;
    }

    public function findByPhone(PhoneNumber $phoneNumber, ?ContactPersonStatus $contactPersonStatus = null, ?bool $isPhoneVerified = null): array
    {
        $result = [];
        foreach ($this->items as $item) {
            if ($phoneNumber !== $item->getMobilePhone()) {
                continue;
            }

            if ($contactPersonStatus instanceof ContactPersonStatus && $contactPersonStatus !== $item->getStatus()) {
                continue;
            }

            if ($isPhoneVerified !== null && $isPhoneVerified !== ($item->getMobilePhoneVerifiedAt() !== null)) {
                continue;
            }

            $result[] = $item;
        }

        return $result;
    }

    public function findByExternalId(string $externalId): ?ContactPersonInterface
    {
        $result = null;
        foreach ($this->items as $item) {
            if ($externalId === $item->getExternalId()) {
                $result = $item;
                break;
            }
        }

        return $result;
    }
}