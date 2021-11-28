<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Contact\Service;

use Bitrix24\SDK\Services\CRM\Contact\Service\ContactUserfield;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Generator;
use PHPUnit\Framework\TestCase;

class ContactUserfieldTest extends TestCase
{
    protected ContactUserfield $contactUserfieldService;

    /**
     * @throws \Exception
     */
    public function systemUserfieldsDemoDataDataProvider(): Generator
    {
        yield 'user type id string' => [
            [
                'FIELD_NAME'        => sprintf('%s%s', substr((string)random_int(0, PHP_INT_MAX), 0, 3), time()),
                'EDIT_FORM_LABEL'   => [
                    'ru' => 'тест uf тип string',
                    'en' => 'test uf type string',
                ],
                'LIST_COLUMN_LABEL' => [
                    'ru' => 'тест uf тип string',
                    'en' => 'test uf type string',
                ],
                'USER_TYPE_ID'      => 'string',
                'XML_ID'            => 'b24phpsdk_type_string',
                'SETTINGS'          => [],
            ],
        ];

        mt_srand();
        yield 'user type id integer' => [
            [
                'FIELD_NAME'        => sprintf('%s%s', substr((string)random_int(0, PHP_INT_MAX), 0, 3), time()),
                'EDIT_FORM_LABEL'   => [
                    'ru' => 'тест uf тип integer',
                    'en' => 'test uf type integer',
                ],
                'LIST_COLUMN_LABEL' => [
                    'ru' => 'тест uf тип integer',
                    'en' => 'test uf type integer',
                ],
                'USER_TYPE_ID'      => 'integer',
                'XML_ID'            => 'b24phpsdk_type_integer',
                'SETTINGS'          => [],
            ],
        ];
    }

    /**
     * @param array $newUserFieldItem
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNameIsTooLongException
     * @covers       ContactUserfield::add
     * @dataProvider systemUserfieldsDemoDataDataProvider
     */
    public function testAdd(array $newUserFieldItem): void
    {
        self::assertGreaterThanOrEqual(1, $this->contactUserfieldService->add($newUserFieldItem)->getId());
    }

    /**
     * @param array $newUserFieldItem
     *
     * @dataProvider systemUserfieldsDemoDataDataProvider
     * @covers       ContactUserfield::delete
     */
    public function testDelete(array $newUserFieldItem): void
    {
        $newUserfieldId = $this->contactUserfieldService->add($newUserFieldItem)->getId();
        $this->assertTrue($this->contactUserfieldService->delete($newUserfieldId)->isSuccess());
    }

    /**
     * @param array $newUserFieldItem
     *
     * @dataProvider systemUserfieldsDemoDataDataProvider
     * @covers       ContactUserfield::get
     */
    public function testGet(array $newUserFieldItem): void
    {
        $newUserfieldId = $this->contactUserfieldService->add($newUserFieldItem)->getId();
        $ufField = $this->contactUserfieldService->get($newUserfieldId)->userfieldItem();
        $this->assertEquals($newUserfieldId, $ufField->ID);
        $this->assertEquals($newUserFieldItem['USER_TYPE_ID'], $ufField->USER_TYPE_ID);
        $this->assertEquals('UF_CRM_' . $newUserFieldItem['FIELD_NAME'], $ufField->FIELD_NAME);
        $this->assertEquals($newUserFieldItem['XML_ID'], $ufField->XML_ID);
    }

    /**
     * @param array $newUserFieldItem
     *
     * @dataProvider systemUserfieldsDemoDataDataProvider
     * @covers       ContactUserfield::update
     */
    public function testUpdate(array $newUserFieldItem): void
    {
        $newUserfieldId = $this->contactUserfieldService->add($newUserFieldItem)->getId();
        $ufFieldBefore = $this->contactUserfieldService->get($newUserfieldId)->userfieldItem();
        $this->assertEquals($newUserfieldId, $ufFieldBefore->ID);
        $this->assertEquals($newUserFieldItem['USER_TYPE_ID'], $ufFieldBefore->USER_TYPE_ID);
        $this->assertEquals('UF_CRM_' . $newUserFieldItem['FIELD_NAME'], $ufFieldBefore->FIELD_NAME);
        $this->assertEquals($newUserFieldItem['XML_ID'], $ufFieldBefore->XML_ID);

        $this->assertTrue(
            $this->contactUserfieldService->update(
                $newUserfieldId,
                [
                    'EDIT_FORM_LABEL' => $newUserFieldItem['EDIT_FORM_LABEL']['en'] . 'QQQ',
                ]
            )->isSuccess()
        );

        $ufFieldAfter = $this->contactUserfieldService->get($newUserfieldId)->userfieldItem();
        $this->assertEquals($ufFieldBefore->EDIT_FORM_LABEL['en'] . 'QQQ', $ufFieldAfter->EDIT_FORM_LABEL['en']);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Contact\Service\ContactUserfield::list
     */
    public function testList(): void
    {
        $ufFields = $this->contactUserfieldService->list([], []);
        $this->assertGreaterThanOrEqual(0, count($ufFields->getUserfields()));
    }

    public function setUp(): void
    {
        $this->contactUserfieldService = Fabric::getServiceBuilder()->getCRMScope()->contactUserfield();
    }
}