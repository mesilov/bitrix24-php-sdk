<?php

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
        protected ?AccessToken        $accessToken,
        protected ?ApplicationProfile $applicationProfile,
        ?string                       $domainUrl
    )
    {
        if ($domainUrl !== null) {
            $this->setDomainUrl($domainUrl);
        }

        if (!$this->accessToken instanceof AccessToken && !$this->webhookUrl instanceof WebhookUrl) {
            throw new InvalidArgumentException('you must set on of auth type: webhook or OAuth 2.0');
        }

        if ($this->accessToken instanceof AccessToken && $this->domainUrl === null) {
            throw new InvalidArgumentException('for oauth type you must set domain url');
        }
    }

    public function setAccessToken(AccessToken $accessToken): void
    {
        $this->accessToken = $accessToken;
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
        return $this->webhookUrl instanceof WebhookUrl && !$this->accessToken instanceof AccessToken;
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

    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
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
    public static function createFromOAuth(AccessToken $accessToken, ApplicationProfile $applicationProfile, string $domainUrl): self
    {
        return new self(
            null,
            $accessToken,
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