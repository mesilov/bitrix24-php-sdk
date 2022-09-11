<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Activity\ReadModel;

use Bitrix24\SDK\Services\CRM\Activity\ReadModel\OpenLineFetcher;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class OpenLineFetcherTest extends TestCase
{
    private OpenLineFetcher $openLineFetcher;

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @covers \Bitrix24\SDK\Services\CRM\Activity\ReadModel\WebFormFetcher::getList
     */
    public function testGetListWithAllResults(): void
    {
        // we can't guarantee open lines data on test env
        $itemsCnt = 0;
        foreach ($this->openLineFetcher->getList(['ID' => 'DESC'], [], ['*', 'COMMUNICATIONS',], null, 5) as $item) {
            $itemsCnt++;
//            print(sprintf(
//                    '%s | %s | %s ',
//                    $item->PROVIDER_TYPE_ID,
//                    $item->CREATED,
//                    $item->SUBJECT,
//                ) . PHP_EOL);
        }
        $this->assertTrue(true);
    }

    public function setUp(): void
    {
        $this->openLineFetcher = Fabric::getServiceBuilder()->getCRMScope()->activityFetcher()->openLineFetcher();
    }
}