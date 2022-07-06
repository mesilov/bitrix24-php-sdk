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

        $this->externalLineService->add((string)time(),sprintf('phpUnit-%s',time()));
        $this->externalLineService->add((string)time(),sprintf('phpUnit-%s',time()));
        self::assertGreaterThanOrEqual(2, $this->externalLineService->get()->getExternalLines());
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->externalLineService = Fabric::getServiceBuilder()->getTelephonyScope()->externalline();
    }

}