<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\ExternalLine\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Services\Telephony;
use Bitrix24\SDK\Services\Telephony\Common\TranscriptMessage;
use Bitrix24\SDK\Services\Telephony\Common\TranscriptMessageSide;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Service\ExternalLine;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Carbon\CarbonImmutable;
use Generator;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
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
     */
    #[Test]
    #[TestDox('Method tests add external line method')]
    public function testExternalLineAdd(): void
    {
        $lineNumber = (string)time();
        $res = $this->externalLine->add($lineNumber, true, sprintf('line-name-%s', $lineNumber));
        $this->assertGreaterThan(0, $res->getExternalLineAddResultItem()->ID);
        $this->assertContains($lineNumber, array_column($this->externalLine->get()->getExternalLines(), 'NUMBER'));
    }

    #[Test]
    #[TestDox('Method tests get external lines method')]
    public function testGetExternalLine(): void
    {
        $externalLinesResult = $this->externalLine->get();
        $this->assertGreaterThan(1, count($externalLinesResult->getExternalLines()));
    }

    #[Test]
    #[TestDox('Method tests delete external line method')]
    public function testDeleteExternalLine(): void
    {
        $lineNumber = (string)time();
        $this->externalLine->add($lineNumber, true, sprintf('line-name-%s', $lineNumber));

        $this->assertContains($lineNumber, array_column($this->externalLine->get()->getExternalLines(), 'NUMBER'));

        $deleteRes = $this->externalLine->delete($lineNumber);
        $this->assertEquals([], $deleteRes->getCoreResponse()->getResponseData()->getResult());

        $this->assertNotContains($lineNumber, array_column($this->externalLine->get()->getExternalLines(), 'NUMBER'));
    }

    protected function setUp(): void
    {
        $this->externalLine = Fabric::getServiceBuilder(true)->getTelephonyScope()->externalLine();
    }
}