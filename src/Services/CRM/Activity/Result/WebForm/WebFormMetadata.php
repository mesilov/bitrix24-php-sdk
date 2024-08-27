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

namespace Bitrix24\SDK\Services\CRM\Activity\Result\WebForm;

class WebFormMetadata
{
    private bool $isUsedUserConsent;
    private array $agreements;
    private string $ip;
    private string $link;

    /**
     * @param bool   $isUsedUserConsent
     * @param array  $agreements
     * @param string $ip
     * @param string $link
     */
    public function __construct(bool $isUsedUserConsent, array $agreements, string $ip, string $link)
    {
        $this->isUsedUserConsent = $isUsedUserConsent;
        $this->agreements = $agreements;
        $this->ip = $ip;
        $this->link = $link;
    }

    /**
     * @return bool
     */
    public function isUsedUserConsent(): bool
    {
        return $this->isUsedUserConsent;
    }

    /**
     * @return array
     */
    public function getAgreements(): array
    {
        return $this->agreements;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}