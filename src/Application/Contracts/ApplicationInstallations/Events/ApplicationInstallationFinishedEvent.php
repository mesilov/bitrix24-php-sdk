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

namespace Bitrix24\SDK\Application\Contracts\ApplicationInstallations\Events;

use Bitrix24\SDK\Application\PortalLicenseFamily;
use Carbon\CarbonImmutable;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

class ApplicationInstallationFinishedEvent extends Event
{
    public function __construct(
        public readonly Uuid                $applicationInstallationId,
        public readonly CarbonImmutable     $timestamp,
        public readonly Uuid                $bitrix24AccountId,
        public readonly PortalLicenseFamily $portalLicenseFamily,
        public readonly ?Uuid               $contactPersonId,
        public readonly ?Uuid               $bitrix24PartnerContactPersonId,
        public readonly ?Uuid               $bitrix24PartnerId)
    {
    }
}