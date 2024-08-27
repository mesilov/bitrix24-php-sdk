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

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Deal\Service;

use Bitrix24\SDK\Services\CRM\Deal\Service\DealUserfield;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Generator;
use PHPUnit\Framework\TestCase;

class DealUserfieldTest extends TestCase
{
    protected DealUserfield $userfieldService;

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
        self::assertGreaterThanOrEqual(1, $this->userfieldService->add($newUserFieldItem)->getId());
    }

    /**
     * @param array $newUserFieldItem
     *
     * @dataProvider systemUserfieldsDemoDataDataProvider
     * @covers       ContactUserfield::delete
     */
    public function testDelete(array $newUserFieldItem): void
    {
        $newUserfieldId = $this->userfieldService->add($newUserFieldItem)->getId();
        $this->assertTrue($this->userfieldService->delete($newUserfieldId)->isSuccess());
    }

    /**
     * @param array $newUserFieldItem
     *
     * @dataProvider systemUserfieldsDemoDataDataProvider
     * @covers       ContactUserfield::get
     */
    public function testGet(array $newUserFieldItem): void
    {
        $newUserfieldId = $this->userfieldService->add($newUserFieldItem)->getId();
        $ufField = $this->userfieldService->get($newUserfieldId)->userfieldItem();
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
        $newUserfieldId = $this->userfieldService->add($newUserFieldItem)->getId();
        $ufFieldBefore = $this->userfieldService->get($newUserfieldId)->userfieldItem();
        $this->assertEquals($newUserfieldId, $ufFieldBefore->ID);
        $this->assertEquals($newUserFieldItem['USER_TYPE_ID'], $ufFieldBefore->USER_TYPE_ID);
        $this->assertEquals('UF_CRM_' . $newUserFieldItem['FIELD_NAME'], $ufFieldBefore->FIELD_NAME);
        $this->assertEquals($newUserFieldItem['XML_ID'], $ufFieldBefore->XML_ID);

        $this->assertTrue(
            $this->userfieldService->update(
                $newUserfieldId,
                [
                    'EDIT_FORM_LABEL' => $newUserFieldItem['EDIT_FORM_LABEL']['en'] . 'QQQ',
                ]
            )->isSuccess()
        );

        $ufFieldAfter = $this->userfieldService->get($newUserfieldId)->userfieldItem();
        $this->assertEquals($ufFieldBefore->EDIT_FORM_LABEL['en'] . 'QQQ', $ufFieldAfter->EDIT_FORM_LABEL['en']);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Contact\Service\ContactUserfield::list
     */
    public function testList(): void
    {
        $ufFields = $this->userfieldService->list([], []);
        $this->assertGreaterThanOrEqual(0, count($ufFields->getUserfields()));
    }

    public function setUp(): void
    {
        $this->userfieldService = Fabric::getServiceBuilder()->getCRMScope()->dealUserfield();
    }
}