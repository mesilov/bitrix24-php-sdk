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

namespace Bitrix24\SDK\Tests\Integration\Services\IMOpenLines\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\IMOpenLines\Service\Network;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Network::class)]
class NetworkTest extends TestCase
{
    private Network $networkService;

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get agreements list')]
    public function testJoin(): void
    {
        $joinOpenLineResult = $this->networkService->join(Fabric::getOpenLineCode());
        $this->assertGreaterThanOrEqual(1, $joinOpenLineResult->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get agreements list')]
    public function testMessageAdd(): void
    {
        $addedMessageItemResult = $this->networkService->messageAdd(
            Fabric::getOpenLineCode(),
            (int)$this->networkService->core->call('PROFILE')->getResponseData()->getResult()['ID'],
            sprintf('Test message at %s', time())
        );

        $this->assertTrue($addedMessageItemResult->isSuccess());
    }

    protected function setUp(): void
    {
        $this->networkService = Fabric::getServiceBuilder()->getIMOpenLinesScope()->Network();
    }
}