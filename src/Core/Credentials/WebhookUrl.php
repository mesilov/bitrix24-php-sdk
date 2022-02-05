<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;

/**
 * Class WebhookUrl
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class WebhookUrl
{
    protected string $url;

    /**
     * @param string $webhookUrl
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function __construct(string $webhookUrl)
    {
        if (filter_var($webhookUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(sprintf('webhook URL %s is invalid', $webhookUrl));
        }
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