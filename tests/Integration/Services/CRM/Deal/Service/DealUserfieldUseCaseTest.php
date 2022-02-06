<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Services\CRM\Deal\Service\DealUserfield;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class DealUserfieldUseCaseTest extends TestCase
{
    protected Deal $dealService;
    protected DealUserfield $dealUserfieldService;
    protected int $dealUserfieldId;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\Deal::add
     */
    public function testOperationsWithUserfieldFromDealItem(): void
    {
        // get userfield metadata
        $ufMetadata = $this->dealUserfieldService->get($this->dealUserfieldId)->userfieldItem();
        $ufOriginalFieldName = $ufMetadata->getOriginalFieldName();
        $ufFieldName = $ufMetadata->FIELD_NAME;

        // add deal with uf value
        $fieldNameValue = 'test field value';
        $newDealId = $this->dealService->add(
            [
                'TITLE'      => 'test deal',
                $ufFieldName => $fieldNameValue,
            ]
        )->getId();
        $deal = $this->dealService->get($newDealId)->deal();
        $this->assertEquals($fieldNameValue, $deal->getUserfieldByFieldName($ufOriginalFieldName));

        // update deal userfield value
        $newUfValue = 'test 2';
        $this->assertTrue(
            $this->dealService->update(
                $deal->ID,
                [
                    $ufFieldName => $newUfValue,
                ]
            )->isSuccess()
        );
        $updatedDeal = $this->dealService->get($deal->ID)->deal();
        $this->assertEquals($newUfValue, $updatedDeal->getUserfieldByFieldName($ufOriginalFieldName));
    }

    /**
     * @throws \Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNameIsTooLongException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function setUp(): void
    {
        $this->dealService = Fabric::getServiceBuilder()->getCRMScope()->deal();
        $this->dealUserfieldService = Fabric::getServiceBuilder()->getCRMScope()->dealUserfield();

        $this->dealUserfieldId = $this->dealUserfieldService->add(
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
                'SETTINGS'          => [
                    'DEFAULT_VALUE' => 'hello world',
                ],
            ]
        )->getId();
    }

    public function tearDown(): void
    {
        $this->dealUserfieldService->delete($this->dealUserfieldId);
    }
}