<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Entity;

use Bitrix24\SDK\Application\Contracts\Bitrix24Accounts\Entity\Bitrix24AccountStatus;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Response\DTO\RenewedAuthToken;
use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;

interface ApplicationInstallationInterface
{
    /**
     * @return Uuid unique application installation id
     */
    public function getId(): Uuid;

    /**
     * @return CarbonImmutable date and time application installation create
     */
    public function getCreatedAt(): CarbonImmutable;

    /**
     * @return CarbonImmutable date and time application installation last change
     */
    public function getUpdatedAt(): CarbonImmutable;

    /**
     * @return Uuid get Bitrix24 Account id related with this installation
     */
    public function getBitrix24AccountId(): Uuid;

    /**
     * @return Uuid|null get contact person id related with this installation, optional
     */
    public function getContactPersonId(): ?Uuid;

    /**
     * @return Uuid|null get Bitrix24 Partner id related with this installation, optional
     */
    public function getBitrix24PartnerId(): ?Uuid;

    /**
     * @return mixed
     * - new
     * - active
     * - blocked
     * - uninstalled
     */
    public function getInstallationStatus();

    /**
     * @return string|null application instalation projection in crm /erp - lead or deal id
     */
    public function getExternalId(): ?string;

    // get application status

    // get tariff code

    // get subscription mode?

}
