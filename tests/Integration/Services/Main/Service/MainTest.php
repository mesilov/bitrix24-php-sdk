<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\Main\Service;

use Bitrix24\SDK\Services\Main;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    private Main\Service\Main $mainService;

    /**
     * @covers  Main\Service\Main::getAvailableMethods
     * @testdox test methods list
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testList(): void
    {
        $this->assertIsArray($this->mainService->getAvailableMethods()->getResponseData()->getResult()->getResultData());
    }

    public function setUp(): void
    {
        $this->mainService = Fabric::getServiceBuilder()->getMainScope()->main();
    }
}