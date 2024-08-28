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

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Application\Requests\Placement\PlacementRequest;

class Credentials
{
    protected ?string $domainUrl = null;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected ?WebhookUrl         $webhookUrl,
        protected ?AuthToken          $authToken,
        protected ?ApplicationProfile $applicationProfile,
        ?string                       $domainUrl
    )
    {
        if ($domainUrl !== null) {
            $this->setDomainUrl($domainUrl);
        }

        if (!$this->authToken instanceof AuthToken && !$this->webhookUrl instanceof WebhookUrl) {
            throw new InvalidArgumentException('you must set on of auth type: webhook or OAuth 2.0');
        }

        if ($this->authToken instanceof AuthToken && $this->domainUrl === null) {
            throw new InvalidArgumentException('for oauth type you must set domain url');
        }
    }

    public function setAuthToken(AuthToken $authToken): void
    {
        $this->authToken = $authToken;
    }

    /**
     * Set domain url
     *
     *
     * @throws InvalidArgumentException
     */
    public function setDomainUrl(string $domainUrl): void
    {
        $parseResult = parse_url($domainUrl);
        if (!array_key_exists('scheme', $parseResult)) {
            $domainUrl = 'https://' . $domainUrl;
        }

        if (filter_var($domainUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(sprintf('domain URL %s is invalid', $domainUrl));
        }

        $this->domainUrl = $domainUrl;
    }

    public function isWebhookContext(): bool
    {
        return $this->webhookUrl instanceof WebhookUrl && !$this->authToken instanceof AuthToken;
    }

    public function getApplicationProfile(): ?ApplicationProfile
    {
        return $this->applicationProfile;
    }

    public function getDomainUrl(): string
    {
        $arUrl = $this->getWebhookUrl() instanceof WebhookUrl ? parse_url($this->getWebhookUrl()->getUrl()) : parse_url((string)$this->domainUrl);

        return sprintf('%s://%s', $arUrl['scheme'], $arUrl['host']);
    }

    public function getWebhookUrl(): ?WebhookUrl
    {
        return $this->webhookUrl;
    }

    public function getAuthToken(): ?AuthToken
    {
        return $this->authToken;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function createFromWebhook(WebhookUrl $webhookUrl): self
    {
        return new self(
            $webhookUrl,
            null,
            null,
            null
        );
    }

    /**
     *
     * @throws InvalidArgumentException
     */
    public static function createFromOAuth(AuthToken $authToken, ApplicationProfile $applicationProfile, string $domainUrl): self
    {
        return new self(
            null,
            $authToken,
            $applicationProfile,
            $domainUrl
        );
    }

    /**
     *
     * @throws InvalidArgumentException
     */
    public static function createFromPlacementRequest(PlacementRequest $placementRequest, ApplicationProfile $applicationProfile): self
    {
        return self::createFromOAuth(
            $placementRequest->getAccessToken(),
            $applicationProfile,
            $placementRequest->getDomainUrl()
        );
    }
}