<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Application\Requests\Placement\PlacementRequest;

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
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
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

        if ($domainUrl !== null) {
            $this->setDomainUrl($domainUrl);
        }

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
     * Set domain url
     *
     * @param string $domainUrl
     *
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
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
        } else {
            $arUrl = parse_url($this->domainUrl);
        }

        return sprintf('%s://%s', $arUrl['scheme'], $arUrl['host']);
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
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
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
     * @param AccessToken        $accessToken
     * @param ApplicationProfile $applicationProfile
     * @param string             $domainUrl
     *
     * @return self
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
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
     * @param \Bitrix24\SDK\Application\Requests\Placement\PlacementRequest $placementRequest
     * @param \Bitrix24\SDK\Core\Credentials\ApplicationProfile             $applicationProfile
     *
     * @return self
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
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