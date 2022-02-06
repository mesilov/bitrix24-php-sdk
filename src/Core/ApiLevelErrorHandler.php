<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\MethodNotFoundException;
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
     * @param array<string,string> $responseBody
     *
     * @throws QueryLimitExceededException
     * @throws BaseException
     */
    public function handle(array $responseBody): void
    {
        if (!array_key_exists(self::ERROR_KEY, $responseBody)) {
            $this->logger->debug('handle.noError');

            return;
        }
        $errorCode = strtolower(trim((string)$responseBody[self::ERROR_KEY]));
        $errorDescription = strtolower(trim((string)$responseBody[self::ERROR_DESCRIPTION_KEY]));
        $this->logger->debug(
            'handle.errorCode',
            [
                'errorCode' => $errorCode,
            ]
        );
        switch ($errorCode) {
            case 'query_limit_exceeded':
                throw new QueryLimitExceededException('query limit exceeded - too many requests');
            case 'error_method_not_found':
                throw new MethodNotFoundException('api method not found');
            default:
                throw new BaseException(sprintf('%s - %s', $errorCode, $errorDescription));
        }
    }
}