<?php

declare(strict_types=1);

/*
 * This file is part of the bitrix24-php-sdk package.
 *
 *  Kirill  Кhramov <k_hram@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Service\ExternalLine;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class ExternalLineTest extends TestCase
{
    protected ExternalLine $externalLineService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers ExternalLine::add
     */
    public function testAdd(): void
    {
        self::assertGreaterThan(1, $this->externalLineService->add((string)time(), sprintf('phpUnit-%s', time()))->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers ExternalLine::get
     */
    public function testGet(): void
    {
        $this->externalLineService->add((string)time(), sprintf('phpUnit-%s', time()));
        $this->externalLineService->add((string)time(), sprintf('phpUnit-%s', time()));
        self::assertGreaterThanOrEqual(2, $this->externalLineService->get()->getExternalLines());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws \Exception
     * @covers ExternalLine::update
     */
    public function testUpdateExternalLineName(): void
    {
        $lineNumber = $this->getRandomLineNumber();
        $lineNameBefore = sprintf('phpUnit-%s-name-before', time());

        $externalLineId = $this->externalLineService->add($lineNumber, $lineNameBefore)->getId();


        $lineNameAfter = sprintf('phpUnit-%s-name-after', time());
        $updatedLineId = $this->externalLineService->update($lineNumber, $lineNameAfter)->updateExternalLineId();
        $this->assertEquals($externalLineId, $updatedLineId, sprintf('external line id %s not equals with %s',
            $externalLineId,
            $updatedLineId
        ));

        $externalLineNameAfter = array_column($this->externalLineService->get()->getExternalLines(), 'NAME');
        self::assertFalse(in_array($lineNameBefore, $externalLineNameAfter),
            sprintf('expected update line name  «%s» line name see %s name', $lineNameBefore, $lineNameAfter));
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @throws \Exception
     * @covers ExternalLine::delete
     */
    public function testDelete(): void
    {
        $lineNumber = $this->getRandomLineNumber();

        self::assertGreaterThan(1, $this->externalLineService->add($lineNumber, sprintf('phpUnit-%s', time()))->getId());
        $externalLineNumbersBefore = array_column($this->externalLineService->get()->getExternalLines(), 'NUMBER');

        $this->externalLineService->delete($lineNumber);
        $externalLineNumbersAfter = array_column($this->externalLineService->get()->getExternalLines(), 'NUMBER');

        $deletedLineNumber = array_values(array_diff($externalLineNumbersBefore, $externalLineNumbersAfter))[0];
        self::assertEquals($lineNumber, $deletedLineNumber, sprintf('expected deleted %s number see %s number', $lineNumber, $deletedLineNumber));
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->externalLineService = Fabric::getServiceBuilder()->getTelephonyScope()->externalline();
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getRandomLineNumber(): string
    {
        return (string)time() . (string)random_int(1, PHP_INT_MAX);
    }
}