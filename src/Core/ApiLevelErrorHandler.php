<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\MethodNotFoundException;
use Bitrix24\SDK\Core\Exceptions\OperationTimeLimitExceededException;
use Bitrix24\SDK\Core\Exceptions\QueryLimitExceededException;
use Psr\Log\LoggerInterface;

/**
 * Handle api-level errors and throw related exception
 *
 * Class ApiLevelErrorHandler
 *
 * @package Bitrix24\SDK\Core
 */
class ApiLevelErrorHandler
{
    protected LoggerInterface $logger;
    protected const ERROR_KEY = 'error';
    protected const RESULT_KEY = 'result';
    protected const RESULT_ERROR_KEY = 'result_error';
    protected const ERROR_DESCRIPTION_KEY = 'error_description';

    /**
     * ApiLevelErrorHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param array<string, mixed> $responseBody
     *
     * @throws QueryLimitExceededException
     * @throws BaseException
     */
    public function handle(array $responseBody): void
    {
        // single query error response
        if (array_key_exists(self::ERROR_KEY, $responseBody) && array_key_exists(self::ERROR_DESCRIPTION_KEY, $responseBody)) {
            $this->handleError($responseBody);
        }

        // error in batch response
        if (!array_key_exists(self::RESULT_KEY, $responseBody) || (!is_array($responseBody[self::RESULT_KEY]))) {
            return;
        }

        if (array_key_exists(self::RESULT_ERROR_KEY, $responseBody[self::RESULT_KEY])) {
            foreach ($responseBody[self::RESULT_KEY][self::RESULT_ERROR_KEY] as $cmdId => $errorData) {
                $this->handleError($errorData, $cmdId);
            }
        }
    }

    /**
     * @throws MethodNotFoundException
     * @throws QueryLimitExceededException
     * @throws BaseException
     */
    private function handleError(array $responseBody, ?string $batchCommandId = null): void
    {
        $errorCode = strtolower(trim((string)$responseBody[self::ERROR_KEY]));
        $errorDescription = strtolower(trim((string)$responseBody[self::ERROR_DESCRIPTION_KEY]));

        $this->logger->debug(
            'handle.errorInformation',
            [
                'errorCode' => $errorCode,
                'errorDescription' => $errorDescription,
            ]
        );

        $batchErrorPrefix = '';
        if ($batchCommandId !== null) {
            $batchErrorPrefix = sprintf(' batch command id: %s', $batchCommandId);
        }

        switch ($errorCode) {
            case 'query_limit_exceeded':
                throw new QueryLimitExceededException(sprintf('query limit exceeded - too many requests %s', $batchErrorPrefix));
            case 'error_method_not_found':
                throw new MethodNotFoundException(sprintf('api method not found %s %s', $errorDescription, $batchErrorPrefix));
            case 'operation_time_limit':
                throw new OperationTimeLimitExceededException(sprintf('operation time limit exceeded %s %s', $errorDescription, $batchErrorPrefix));
            default:
                throw new BaseException(sprintf('%s - %s %s', $errorCode, $errorDescription, $batchErrorPrefix));
        }
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
}