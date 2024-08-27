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

namespace Bitrix24\SDK\Tests\Unit\Core;

use Bitrix24\SDK\Core\ApiLevelErrorHandler;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\OperationTimeLimitExceededException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Core\ApiLevelErrorHandler::class)]
class ApiLevelErrorHandlerTest extends TestCase
{
    private ApiLevelErrorHandler $apiLevelErrorHandler;

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\QueryLimitExceededException
     */
    #[\PHPUnit\Framework\Attributes\TestDox('Test operating error in bach mode')]
    public function testOperatingErrorInBachMode(): void
    {
        $this->expectException(OperationTimeLimitExceededException::class);

        $response = [
            'result' => [
                'result' => [],
                'result_error' => [
                    "592dcd1e-cd14-410f-bab5-76b3ede717dd" => [
                        'error' => 'OPERATION_TIME_LIMIT',
                        'error_description' => 'Method is blocked due to operation time limit.'
                    ]
                ]
            ],
        ];

        $this->apiLevelErrorHandler->handle($response);
    }

    protected function setUp(): void
    {
        $this->apiLevelErrorHandler = new ApiLevelErrorHandler(new NullLogger());
    }
}
