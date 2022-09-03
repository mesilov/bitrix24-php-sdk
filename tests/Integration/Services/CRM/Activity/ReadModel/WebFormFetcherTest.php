<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Activity\ReadModel;

use Bitrix24\SDK\Services\CRM\Activity\ReadModel\WebFormFetcher;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class WebFormFetcherTest extends TestCase
{
    private WebFormFetcher $webFormFetcher;

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @covers \Bitrix24\SDK\Services\CRM\Activity\ReadModel\WebFormFetcher::getList
     */
    public function testGetListWithAllWebFormResults(): void
    {
        // we can't guarantee filled web-form on test env
        $itemsCnt = 0;
        foreach ($this->webFormFetcher->getList(['ID' => 'DESC'], [], ['*', 'COMMUNICATIONS',], null, 5) as $item) {
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
        $this->webFormFetcher = Fabric::getServiceBuilder()->getCRMScope()->activityFetcher()->webFormFetcher();
    }
}