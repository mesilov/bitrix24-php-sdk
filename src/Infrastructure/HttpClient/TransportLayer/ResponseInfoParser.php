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

namespace Bitrix24\SDK\Infrastructure\HttpClient\TransportLayer;

class ResponseInfoParser
{
    private array $responseInfo;

    /**
     * @param array $httpClientResponseInfo
     */
    public function __construct(array $httpClientResponseInfo)
    {
        $this->responseInfo = $httpClientResponseInfo;
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        return [
            // canceled (bool) - true if the response was canceled using ResponseInterface::cancel(), false otherwise
            'canceled'       => $this->responseInfo['canceled'],
            // error (string|null) - the error message when the transfer was aborted, null otherwise
            'error'          => $this->responseInfo['error'],
            // http_code (int) - the last response code or 0 when it is not known yet
            'http_code'      => $this->responseInfo['http_code'],
            // http_method (string) - the HTTP verb of the last request
            'http_method'    => $this->responseInfo['http_method'],
            // redirect_count (int) - the number of redirects followed while executing the request
            'redirect_count' => $this->responseInfo['redirect_count'],
            // redirect_url (string|null) - the resolved location of redirect responses, null otherwise
            'redirect_url'   => $this->responseInfo['redirect_url'],
            // start_time (float) - the time when the request was sent or 0.0 when it's pending
            'start_time'     => $this->responseInfo['start_time'],
            // url (string) - the last effective URL of the request
            'url'            => $this->responseInfo['url'],
        ];
    }
}