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

namespace Bitrix24\SDK\Core\Response;

use Bitrix24\SDK\Core\ApiLevelErrorHandler;
use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\DTO;
use Bitrix24\SDK\Infrastructure\HttpClient\TransportLayer\NetworkTimingsParser;
use Bitrix24\SDK\Infrastructure\HttpClient\TransportLayer\ResponseInfoParser;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class Response
{
    protected ?DTO\ResponseData $responseData = null;

    /**
     * Response constructor.
     */
    public function __construct(
        protected ResponseInterface    $httpResponse,
        protected Command              $apiCommand,
        protected ApiLevelErrorHandler $apiLevelErrorHandler,
        protected LoggerInterface      $logger)
    {
    }

    public function getHttpResponse(): ResponseInterface
    {
        return $this->httpResponse;
    }

    public function getApiCommand(): Command
    {
        return $this->apiCommand;
    }

    /**
     * @throws BaseException
     */
    public function getResponseData(): DTO\ResponseData
    {
        $this->logger->debug('getResponseData.start');

        if (!$this->responseData instanceof \Bitrix24\SDK\Core\Response\DTO\ResponseData) {
            try {
                $this->logger->debug('getResponseData.parseResponse.start');
                $responseResult = $this->httpResponse->toArray(true);
                $this->logger->info('getResponseData.responseBody', [
                    'responseBody' => $responseResult,
                ]);

                // try to handle api-level errors
                $this->apiLevelErrorHandler->handle($responseResult);

                if (!is_array($responseResult['result'])) {
                    $responseResult['result'] = [$responseResult['result']];
                }

                $nextItem = null;
                $total = null;
                if (array_key_exists('next', $responseResult)) {
                    $nextItem = (int)$responseResult['next'];
                }

                if (array_key_exists('total', $responseResult)) {
                    $total = (int)$responseResult['total'];
                }

                $this->responseData = new DTO\ResponseData(
                    $responseResult['result'],
                    DTO\Time::initFromResponse($responseResult['time']),
                    new DTO\Pagination($nextItem, $total)
                );
                $this->logger->debug('getResponseData.parseResponse.finish');
            } catch (Throwable $exception) {
                $this->logger->error(
                    $exception->getMessage(),
                    [
                        'response' => $this->getHttpResponseContent(),
                    ]
                );
                throw new BaseException(sprintf('api request error: %s', $exception->getMessage()), $exception->getCode(), $exception);
            }
        }

        $this->logger->debug('getResponseData.finish');

        return $this->responseData;
    }

    private function getHttpResponseContent(): ?string
    {
        $content = null;
        try {
            $content = $this->httpResponse->getContent(false);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());
        }

        return $content;
    }
}