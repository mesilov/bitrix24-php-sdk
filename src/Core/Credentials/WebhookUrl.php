<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

/**
 * Class WebhookUrl
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class WebhookUrl
{
    /**
     * @var string
     */
    protected $url;

    /**
     * WebHookToken constructor.
     *
     * @param string $webhookUrl
     */
    public function __construct(string $webhookUrl)
    {
        $this->url = $webhookUrl;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}