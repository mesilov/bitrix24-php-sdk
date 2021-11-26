<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

/**
 * Class Credentials
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class Credentials
{
    protected ?WebhookUrl $webhookUrl;
    protected ?AccessToken $accessToken;
    protected ?ApplicationProfile $applicationProfile;
    protected ?string $domainUrl;

    /**
     * Credentials constructor.
     *
     * @param WebhookUrl|null         $webhookUrl
     * @param AccessToken|null        $accessToken
     * @param ApplicationProfile|null $applicationProfile
     * @param string|null             $domainUrl
     */
    public function __construct(
        ?WebhookUrl $webhookUrl,
        ?AccessToken $accessToken,
        ?ApplicationProfile $applicationProfile,
        ?string $domainUrl
    ) {
        $this->webhookUrl = $webhookUrl;
        $this->accessToken = $accessToken;
        $this->applicationProfile = $applicationProfile;
        $this->domainUrl = $domainUrl;
        if ($this->accessToken === null && $this->webhookUrl === null) {
            throw new \LogicException('you must set on of auth type: webhook or OAuth 2.0');
        }
        if ($this->accessToken !== null && $this->domainUrl === null) {
            throw new \LogicException('for oauth type you must set domain url');
        }
    }

    /**
     * @param AccessToken $accessToken
     */
    public function setAccessToken(AccessToken $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return ApplicationProfile|null
     */
    public function getApplicationProfile(): ?ApplicationProfile
    {
        return $this->applicationProfile;
    }

    /**
     * @return string
     */
    public function getDomainUrl(): string
    {
        if ($this->getWebhookUrl() !== null) {
            $arUrl = parse_url($this->getWebhookUrl()->getUrl());

            $url = sprintf('%s://%s', $arUrl['scheme'], $arUrl['host']);
        } else {
            $url = $this->domainUrl;
        }

        return $url;
    }

    /**
     * @return WebhookUrl|null
     */
    public function getWebhookUrl(): ?WebhookUrl
    {
        return $this->webhookUrl;
    }

    /**
     * @return AccessToken|null
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @param WebhookUrl $webhookUrl
     *
     * @return self
     */
    public static function createForWebHook(WebhookUrl $webhookUrl): self
    {
        return new self(
            $webhookUrl,
            null,
            null,
            null
        );
    }

    /**
     * @param AccessToken        $accessToken
     * @param ApplicationProfile $applicationProfile
     * @param string             $domainUrl
     *
     * @return self
     */
    public static function createForOAuth(AccessToken $accessToken, ApplicationProfile $applicationProfile, string $domainUrl): self
    {
        return new self(
            null,
            $accessToken,
            $applicationProfile,
            $domainUrl
        );
    }
}