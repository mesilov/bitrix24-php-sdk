<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Userfield\Service;

use Bitrix24\SDK\Services\CRM\Userfield\Service\Userfield;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class UserfieldTest extends TestCase
{
    protected Userfield $userfieldService;

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Userfield\Service\Userfield::fields
     */
    public function testFields(): void
    {
        self::assertIsArray($this->userfieldService->fields()->getFieldsDescription());
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Userfield\Service\Userfield::enumerationFields
     */
    public function testEnumerationFields(): void
    {
        self::assertIsArray($this->userfieldService->enumerationFields()->getFieldsDescription());
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Userfield\Service\Userfield::settingsFields
     */
    public function testSettingsFields(): void
    {
        foreach ($this->userfieldService->types()->getTypes() as $typeItem) {
            self::assertIsArray($this->userfieldService->settingsFields($typeItem->ID)->getFieldsDescription());
        }
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Userfield\Service\Userfield::types
     */
    public function testTypes(): void
    {
        $ufTypes = $this->userfieldService->types();
        $this->assertGreaterThan(10, $ufTypes->getTypes());
    }


    public function setUp(): void
    {
        $this->userfieldService = Fabric::getServiceBuilder()->getCRMScope()->userfield();
    }
}