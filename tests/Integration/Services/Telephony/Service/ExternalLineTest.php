<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Service\ExternalLine;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class ExternalLineTest extends TestCase {
    protected ExternalLine $externalLineService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers ExternalLine::add
     */
    public function testAdd(): void
    {
       self::assertGreaterThan(1,$this->externalLineService->add((string)time(),sprintf('phpUnit-%s',time()))->getId());

    }

    /**
     * * @throws BaseException
     * @throws TransportException
     * @covers ExternalLine::get
     */
    public function testGet(): void
    {
      //  $this->externalLineService->add((string)time(),sprintf('phpUnit-%s',time()));
      //  $this->externalLineService->add((string)time(),sprintf('phpUnit-%s',time()));
        self::assertGreaterThanOrEqual(2, $this->externalLineService->get()->getExternalLines());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers ExternalLine::update
     */
    public function testUpdateExternalLineName():void
    {

        //$lineNameBefore = array((string)time() => sprintf('phpUnit-%s',time()));
        $lineNumber = (string)time();
        $lineNameBefore = sprintf('phpUnit-%s',time());

        self::assertGreaterThan(1,$this->externalLineService->add($lineNumber,$lineNameBefore)->getId());
        $externalLineNameBefore = array_column($this->externalLineService->get()->getExternalLines(),'NAME');
        var_dump($externalLineNameBefore);

        $lineNameAfter = sprintf('phpUnit-%s-second',time());
        $this->externalLineService->update($lineNumber,$lineNameAfter)->updateExternalLineId();
        $externalLineNameAfter = array_column($this->externalLineService->get()->getExternalLines(),'NAME');
        var_dump($externalLineNameAfter);
        self::assertFalse(in_array($lineNameBefore,$externalLineNameAfter),sprintf('expected update %s line name see %s name',$lineNameBefore,$lineNameAfter));

      /*
      self::assertGreaterThan(1,$this->externalLineService->add('8765890978','oldName')->getId());
      self::assertGreaterThan(1,$this->externalLineService->update('8765890978','newTestLine')->updateExternalLineId());
      self::assertGreaterThan(1,$this->externalLineService->get()->getExternalLines());
      */
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers ExternalLine::delete
     */
    public function testDelete():void
    {
        $lineNumber = (string)time().(string)random_int(1,PHP_INT_MAX);
var_dump($lineNumber);
        self::assertGreaterThan(1,$this->externalLineService->add($lineNumber,sprintf('phpUnit-%s',time()))->getId());
        $externalLineNumbersBefore = array_column($this->externalLineService->get()->getExternalLines(),'NUMBER');

        $this->externalLineService->delete($lineNumber);
        $externalLineNumbersAfter = array_column($this->externalLineService->get()->getExternalLines(),'NUMBER');

        $deletedLineNumber = array_values(array_diff($externalLineNumbersBefore,$externalLineNumbersAfter))[0];
      var_dump(array_values(array_diff($externalLineNumbersBefore,$externalLineNumbersAfter)));
        self::assertEquals($lineNumber,$deletedLineNumber,sprintf('expected deleted %s number see %s number',$lineNumber,$deletedLineNumber));
    }


    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->externalLineService = Fabric::getServiceBuilder()->getTelephonyScope()->externalline();
    }

}