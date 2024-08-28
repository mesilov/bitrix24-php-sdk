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

namespace Bitrix24\SDK\Tests\Unit\Application\Contracts\Bitrix24Partners\Entity;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerInterface;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Entity\Bitrix24PartnerStatus;
use Bitrix24\SDK\Application\Contracts\Bitrix24Partners\Events\Bitrix24PartnerExternalIdChangedEvent;
use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\ContactPersonStatus;
use Bitrix24\SDK\Application\Contracts\Events\AggregateRootEventsEmitterInterface;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;
use Carbon\CarbonImmutable;
use libphonenumber\PhoneNumber;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class Bitrix24PartnerReferenceEntityImplementation
 *
 * This class uses ONLY for demonstration and tests interface, use cases for work with Bitrix24PartnerInterface methods
 *
 */
final class Bitrix24PartnerReferenceEntityImplementation implements Bitrix24PartnerInterface, AggregateRootEventsEmitterInterface
{
    private ?string $comment = null;

    private array $events = [];

    public function __construct(
        private readonly Uuid            $id,
        private readonly CarbonImmutable $createdAt,
        private CarbonImmutable          $updatedAt,
        private Bitrix24PartnerStatus    $bitrix24PartnerStatus,
        private string                   $title,
        private ?int                     $bitrix24PartnerId,
        private ?string                  $site,
        private ?PhoneNumber             $phoneNumber,
        private ?string                  $email,
        private ?string                  $openLineId,
        private ?string                  $externalId
    )
    {
    }

    public function emitEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): void
    {
        if ($externalId !== null && trim($externalId) === '') {
            throw new InvalidArgumentException('externalId cannot be an empty string');
        }

        $prevExternalId = $this->externalId;
        $this->externalId = $externalId;
        $this->updatedAt = new CarbonImmutable();

        $this->events[] = new Bitrix24PartnerExternalIdChangedEvent(
            $this->id,
            $this->updatedAt,
            $prevExternalId,
            $this->externalId
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        if (trim($title) === '') {
            throw new InvalidArgumentException('partner title cannot be an empty string');
        }

        $this->title = $title;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): void
    {
        if ($site !== null && trim($site) === '') {
            throw new InvalidArgumentException('site cannot be an empty string');
        }

        $this->site = $site;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getPhone(): ?PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function setPhone(?PhoneNumber $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        if ($email !== null && trim($email) === '') {
            throw new InvalidArgumentException('email cannot be an empty string');
        }

        if ($email !== null && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('invalid email «%s»', $email));
        }

        $this->email = $email;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getBitrix24PartnerId(): ?int
    {
        return $this->bitrix24PartnerId;
    }

    public function setBitrix24PartnerId(?int $bitrix24PartnerId): void
    {
        if ($bitrix24PartnerId !== null && $bitrix24PartnerId <= 0) {
            throw new InvalidArgumentException(sprintf('bitrix24 partner id must be positive int, now «%s»', $bitrix24PartnerId));
        }

        $this->bitrix24PartnerId = $bitrix24PartnerId;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getOpenLineId(): ?string
    {
        return $this->openLineId;
    }

    public function setOpenLineId(?string $openLineId): void
    {
        if ($openLineId !== null && trim($openLineId) === '') {
            throw new InvalidArgumentException('openLineId cannot be an empty string');
        }

        $this->openLineId = $openLineId;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getStatus(): Bitrix24PartnerStatus
    {
        return $this->bitrix24PartnerStatus;
    }

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): CarbonImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function markAsActive(?string $comment): void
    {
        if (Bitrix24PartnerStatus::blocked !== $this->bitrix24PartnerStatus) {
            throw new InvalidArgumentException(
                sprintf('you can activate bitrix24 partner only in status blocked, now bitrix24 partner in status %s',
                    $this->bitrix24PartnerStatus->name));
        }

        $this->bitrix24PartnerStatus = Bitrix24PartnerStatus::active;
        $this->comment = $comment;
        $this->updatedAt = new CarbonImmutable();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function markAsBlocked(?string $comment): void
    {
        if (Bitrix24PartnerStatus::deleted === $this->bitrix24PartnerStatus || Bitrix24PartnerStatus::blocked === $this->bitrix24PartnerStatus) {
            throw new InvalidArgumentException(
                sprintf('you cannot block bitrix24 partner in status «%s»',
                    $this->bitrix24PartnerStatus->name
                ));
        }

        $this->bitrix24PartnerStatus = Bitrix24PartnerStatus::blocked;
        $this->comment = $comment;
        $this->updatedAt = new CarbonImmutable();
    }

    public function markAsDeleted(?string $comment): void
    {
        if (Bitrix24PartnerStatus::deleted === $this->bitrix24PartnerStatus) {
            throw new InvalidArgumentException(
                sprintf('you cannot mark bitrix24 partner as deleted in status %s',
                    $this->bitrix24PartnerStatus->name));
        }

        $this->bitrix24PartnerStatus = Bitrix24PartnerStatus::deleted;
        $this->comment = $comment;
        $this->updatedAt = new CarbonImmutable();
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
