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

namespace Bitrix24\SDK\Tests\Integration\Services\Placement\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\IM\Notify\Service\Notify;
use Bitrix24\SDK\Services\IMOpenLines\Service\Network;
use Bitrix24\SDK\Services\Placement\Result\PlacementLocationItemResult;
use Bitrix24\SDK\Services\Placement\Service\Placement;
use Bitrix24\SDK\Services\Placement\Service\PlacementLocationCode;
use Bitrix24\SDK\Services\Telephony\Call\Service\Call;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Placement::class)]
class PlacementTest extends TestCase
{
    private Placement $placementService;

    #[Test]
    #[TestDox('Test method bind')]
    public function testBind(): void
    {
        /**
         * @var PlacementLocationItemResult[] $placements
         */
        $placements = $this->placementService->get()->getPlacementsLocationInformation();
        foreach ($placements as $placement) {
            $this->assertGreaterThanOrEqual(0, $this->placementService->unbind($placement->placement)->getDeletedPlacementHandlersCount());
        }

        $placementBindResult = $this->placementService->bind(
            PlacementLocationCode::CRM_CONTACT_DETAIL_TAB,
            'https://bitrix24test.com', [
            'en' => [
                'TITLE' => 'test app'
            ]
        ]);
        $this->assertTrue($placementBindResult->isSuccess());
        $placement = $this->placementService->get()->getPlacementsLocationInformation()[0];
        $this->assertEquals(PlacementLocationCode::CRM_CONTACT_DETAIL_TAB, $placement->placement);
        $this->placementService->unbind(PlacementLocationCode::CRM_CONTACT_DETAIL_TAB)->getDeletedPlacementHandlersCount();
    }

    #[Test]
    #[TestDox('Test method unbind')]
    public function testUnbind(): void
    {
        /**
         * @var PlacementLocationItemResult[] $placements
         */
        $placements = $this->placementService->get()->getPlacementsLocationInformation();
        foreach ($placements as $placement) {
            $this->assertGreaterThanOrEqual(0, $this->placementService->unbind($placement->placement)->getDeletedPlacementHandlersCount());
        }

        $placementBindResult = $this->placementService->bind(
            PlacementLocationCode::CRM_CONTACT_DETAIL_TAB,
            'https://bitrix24test.com', [
            'en' => [
                'TITLE' => 'test app'
            ]
        ]);
        $this->assertTrue($placementBindResult->isSuccess());
        $placement = $this->placementService->get()->getPlacementsLocationInformation()[0];
        $this->assertEquals(PlacementLocationCode::CRM_CONTACT_DETAIL_TAB, $placement->placement);

        $this->placementService->unbind(PlacementLocationCode::CRM_CONTACT_DETAIL_TAB)->getDeletedPlacementHandlersCount();

    }

    #[Test]
    #[TestDox('Test method get')]
    public function testGet(): void
    {
        $placementsLocationInformationResult = $this->placementService->get();
        $this->assertGreaterThanOrEqual(0, count($placementsLocationInformationResult->getPlacementsLocationInformation()));
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[Test]
    #[TestDox('Test method list')]
    public function testList(): void
    {
        $placementLocationCodesResult = $this->placementService->list();
        $this->assertGreaterThanOrEqual(0, count($placementLocationCodesResult->getLocationCodes()));
    }

    protected function setUp(): void
    {
        $this->placementService = Fabric::getServiceBuilder(true)->getPlacementScope()->placement();
    }
}