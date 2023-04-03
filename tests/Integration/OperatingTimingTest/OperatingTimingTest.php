<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\OperatingTimingTest;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

/**
 * Class OperatingTimingTest
 *
 * @package Bitrix24\SDK\Tests\Integration\OperatingTimingTest
 */
class OperatingTimingTest extends TestCase
{
    protected Contact $contactService;
    protected Batch $batch;

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testOperatingTiming(): void
    {

        $timeStart = microtime(true);
        $contactsToUpdate = [];
        foreach ($this->contactService->batch->list([], ['>ID' => '12'], ['ID', 'PHONE'], 30000) as $contactList) {
            $contactsToUpdate[$contactList->ID] = [
                'fields' => [
                    'PHONE' => [['ID' => $contactList->PHONE[0]['ID']]]
                ],
                'params' => [],
            ];
            $contactListId[] = $contactList->ID;
        }
        foreach ($this->contactService->batch->update($contactsToUpdate) as $dealUpdateResult) {
            $logOperating[] = $dealUpdateResult->getResponseData()->getTime()->getOperating();
            $logOperatingResetAt = $dealUpdateResult->getResponseData()->getTime()->getOperatingResetAt();
            $sumOperating = array_sum($logOperating);
            echo "summa operating: " . $sumOperating . PHP_EOL;
            echo "operating rest at: " . $logOperatingResetAt . PHP_EOL;
        }
        $timeEnd = microtime(true);
        echo sprintf('batch query duration: %s seconds', round($timeEnd - $timeStart, 2)) . PHP_EOL;

        self::assertGreaterThanOrEqual(5, $contactListId);

    }

    public function setUp(): void
    {
        $this->batch = Fabric::getBatchService();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }
}