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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\ExternalLine\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Service\ExternalLine;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Random\RandomException;

#[CoversClass(ExternalLine::class)]
#[CoversClass(ExternalLine::class)]
class ExternalLineTest extends TestCase
{
    private ExternalLine $externalLine;

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws RandomException
     */
    #[Test]
    #[TestDox('Method tests add external line method')]
    public function testExternalLineAdd(): void
    {
        $lineNumber = time() . abs(random_int(PHP_INT_MIN, PHP_INT_MAX));
        $externalLineAddedResult = $this->externalLine->add($lineNumber, true, sprintf('line-name-%s', $lineNumber));
        $this->assertGreaterThan(0, $externalLineAddedResult->getExternalLineAddResultItem()->ID);
        $this->assertContains($lineNumber, array_column($this->externalLine->get()->getExternalLines(), 'NUMBER'));
    }

    #[Test]
    #[TestDox('Method tests get external lines method')]
    public function testGetExternalLine(): void
    {
        $externalLinesResult = $this->externalLine->get();
        $this->assertGreaterThan(1, count($externalLinesResult->getExternalLines()));
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws RandomException
     */
    #[Test]
    #[TestDox('Method tests delete external line method')]
    public function testDeleteExternalLine(): void
    {
        $lineNumber = time() . abs(random_int(PHP_INT_MIN, PHP_INT_MAX));
        $this->externalLine->add($lineNumber, true, sprintf('line-name-%s', $lineNumber));

        $this->assertContains($lineNumber, array_column($this->externalLine->get()->getExternalLines(), 'NUMBER'));

        $emptyResult = $this->externalLine->delete($lineNumber);
        $this->assertEquals([], $emptyResult->getCoreResponse()->getResponseData()->getResult());

        $this->assertNotContains($lineNumber, array_column($this->externalLine->get()->getExternalLines(), 'NUMBER'));
    }

    protected function setUp(): void
    {
        $this->externalLine = Fabric::getServiceBuilder(true)->getTelephonyScope()->externalLine();
    }
}