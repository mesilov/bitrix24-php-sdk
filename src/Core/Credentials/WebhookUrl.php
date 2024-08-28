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

/**
 * Class WebhookUrl
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class WebhookUrl
{
    protected string $url;

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function __construct(string $webhookUrl)
    {
        if (filter_var($webhookUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(sprintf('webhook URL %s is invalid', $webhookUrl));
        }

        $this->url = $webhookUrl;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}