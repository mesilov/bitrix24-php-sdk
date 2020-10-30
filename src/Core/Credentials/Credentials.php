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
    /**
     * @var WebhookUrl|null
     */
    protected $webhookUrl;
    /**
     * @var OAuthToken|null
     */
    protected $oauthToken;
    /**
     * @var string|null
     */
    protected $domainUrl;

    /**
     * Credentials constructor.
     *
     * @param WebhookUrl|null $webhookUrl
     * @param OAuthToken|null $oauthToken
     * @param string|null     $domainUrl
     */
    public function __construct(?WebhookUrl $webhookUrl, ?OAuthToken $oauthToken, ?string $domainUrl)
    {
        $this->webhookUrl = $webhookUrl;
        $this->oauthToken = $oauthToken;
        $this->domainUrl = $domainUrl;
        if ($this->oauthToken === null && $this->webhookUrl === null) {
            throw new \LogicException(sprintf('you must set on of auth type: webhook or oauth'));
        }
        if ($this->oauthToken !== null && $this->domainUrl === null) {
            throw new \LogicException(sprintf('for oauth type you must set domain url'));
        }
    }

    /**
     * @return string
     */
    public function getDomainUrl(): string
    {
        if ($this->getWebhookUrl() !== null) {
            $url = parse_url($this->getWebhookUrl()->getUrl())['host'];
        } else {
            $url = $this->getDomainUrl();
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
     * @return OAuthToken|null
     */
    public function getOauthToken(): ?OAuthToken
    {
        return $this->oauthToken;
    }
}