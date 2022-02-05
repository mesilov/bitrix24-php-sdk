<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response;

use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Response\DTO;
use Bitrix24\SDK\Infrastructure\HttpClient\TransportLayer\NetworkTimingsParser;
use Bitrix24\SDK\Infrastructure\HttpClient\TransportLayer\ResponseInfoParser;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

/**
 * Class Response
 *
 * @package Bitrix24\SDK\Core\Response
 */
class Response
{
    protected ResponseInterface $httpResponse;
    protected LoggerInterface $logger;
    protected ?DTO\ResponseData $responseData;
    protected Command $apiCommand;

    /**
     * Response constructor.
     *
     * @param ResponseInterface $httpResponse
     * @param Command           $apiCommand
     * @param LoggerInterface   $logger
     */
    public function __construct(ResponseInterface $httpResponse, Command $apiCommand, LoggerInterface $logger)
    {
        $this->httpResponse = $httpResponse;
        $this->apiCommand = $apiCommand;
        $this->logger = $logger;
        $this->responseData = null;
    }

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->httpResponse;
    }

    /**
     * @return Command
     */
    public function getApiCommand(): Command
    {
        return $this->apiCommand;
    }

    public function __destruct()
    {
        // пишем эту информацию в деструкторе, т.к. метод getResponseData может и не быть вызван
        // логировать в конструкторе смысла нет, т.к. запрос ещё может не завершиться из-за того,
        // что он асинхронный и неблокирующий
        $restTimings = null;
        if ($this->responseData !== null) {
            $restTimings = [
                'rest_query_duration'   => $this->responseData->getTime()->getDuration(),
                'rest_query_processing' => $this->responseData->getTime()->getProcessing(),
                'rest_query_start'      => $this->responseData->getTime()->getStart(),
                'rest_query_finish'     => $this->responseData->getTime()->getFinish(),
            ];
        }
        $this->logger->info('Response.TransportInfo', [
            'restTimings'    => $restTimings,
            'networkTimings' => (new NetworkTimingsParser($this->httpResponse->getInfo()))->toArrayWithMicroseconds(),
            'responseInfo'   => (new ResponseInfoParser($this->httpResponse->getInfo()))->toArray(),
        ]);
    }

    /**
     * @return DTO\ResponseData
     * @throws BaseException
     */
    public function getResponseData(): DTO\ResponseData
    {
        $this->logger->debug('getResponseData.start');

        if ($this->responseData === null) {
            try {
                $this->logger->debug('getResponseData.parseResponse.start');
                $responseResult = $this->httpResponse->toArray(true);
                $this->logger->info('getResponseData.responseBody', [
                    'responseBody' => $responseResult,
                ]);
                // try to handle api-level errors
                $this->handleApiLevelErrors($responseResult);

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
                    new DTO\Result($responseResult['result']),
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

    /**
     * @return string|null
     */
    private function getHttpResponseContent(): ?string
    {
        $content = null;
        try {
            $content = $this->httpResponse->getContent(false);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $content;
    }

    /**
     * @param array $apiResponse
     */
    private function handleApiLevelErrors(array $apiResponse): void
    {
        $this->logger->debug('handleApiLevelErrors.start');

        if (array_key_exists('error', $apiResponse)) {
            $errorMsg = sprintf(
                '%s - %s ',
                $apiResponse['error'],
                (array_key_exists('error_description', $apiResponse) ? $apiResponse['error_description'] : ''),
            );
// todo check api-level error codes
//
//            switch (strtoupper(trim($apiResponse['error']))) {
//                case 'EXPIRED_TOKEN':
//                    throw new Bitrix24TokenIsExpiredException($errorMsg);
//                case 'WRONG_CLIENT':
//                case 'ERROR_OAUTH':
//                    $this->log->error($errorMsg, $this->getErrorContext());
//                    throw new Bitrix24WrongClientException($errorMsg);
//                case 'ERROR_METHOD_NOT_FOUND':
//                    $this->log->error($errorMsg, $this->getErrorContext());
//                    throw new Bitrix24MethodNotFoundException($errorMsg);
//                case 'INVALID_TOKEN':
//                case 'INVALID_GRANT':
//                    $this->log->error($errorMsg, $this->getErrorContext());
//                    throw new Bitrix24TokenIsInvalidException($errorMsg);

//                case 'PAYMENT_REQUIRED':
//                    $this->log->error($errorMsg, $this->getErrorContext());
//                    throw new Bitrix24PaymentRequiredException($errorMsg);
//                case 'NO_AUTH_FOUND':
//                    $this->log->error($errorMsg, $this->getErrorContext());
//                    throw new Bitrix24PortalRenamedException($errorMsg);
//                case 'INSUFFICIENT_SCOPE':
//                    $this->log->error($errorMsg, $this->getErrorContext());
//                    throw new Bitrix24InsufficientScope($errorMsg);
//                default:
//                    $this->log->error($errorMsg, $this->getErrorContext());
//                    throw new Bitrix24ApiException($errorMsg);
        }
        $this->logger->debug('handleApiLevelErrors.finish');
    }
}