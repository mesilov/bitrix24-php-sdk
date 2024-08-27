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

namespace Bitrix24\SDK\Tests\Integration\Core;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Batch::class)]
class BatchGetTraversableTest extends TestCase
{
    private Batch $batch;
    private ServiceBuilder $serviceBuilder;
    private array $createdContactIds;

    #[TestDox('test get contacts in batch mode with more than one page but only one batch query')]
    public function testSingleBatchWithMoreThanOnePage(): void
    {
        $greaterThanDefaultPageSize = 120;
        $originatorId = Uuid::v7()->toRfc4122();
        // add contacts
        $contacts = [];
        for ($i = 0; $i < $greaterThanDefaultPageSize; $i++) {
            $contacts[] = [
                'fields' => [
                    'NAME' => 'name-' . $i,
                    'ORIGINATOR_ID' => $originatorId
                ]
            ];
        }
        $cnt = 0;
        foreach ($this->batch->addEntityItems('crm.contact.add', $contacts) as $addedContactResult) {
            $this->createdContactIds[] = $addedContactResult->getResult()[0];
            $cnt++;
        }
        $this->assertEquals(count($contacts), $cnt);
        $this->assertEquals(count($contacts), $this->serviceBuilder->getCRMScope()->contact()->countByFilter([
            'ORIGINATOR_ID' => $originatorId
        ]));

        $readContactsId = [];
        foreach ($this->batch->getTraversableList('crm.contact.list',
            [],
            [
                'ORIGINATOR_ID' => $originatorId
            ],
            [
                'ID',
                'NAME',
                'ORIGINATOR_ID'
            ]
        ) as $cnt => $itemContact) {
            $readContactsId[] = $itemContact['ID'];
        }
        $this->assertEquals($this->createdContactIds, $readContactsId);
    }

    #[TestDox('test get contacts in batch mode with more than one page but only one batch query and limit argument')]
    public function testSingleBatchWithMoreThanOnePageAndLimit(): void
    {
        $greaterThanDefaultPageSize = 120;
        $originatorId = Uuid::v7()->toRfc4122();
        // add contacts
        $contacts = [];
        for ($i = 0; $i < $greaterThanDefaultPageSize; $i++) {
            $contacts[] = [
                'fields' => [
                    'NAME' => 'name-' . $i,
                    'ORIGINATOR_ID' => $originatorId
                ]
            ];
        }
        $cnt = 0;
        foreach ($this->batch->addEntityItems('crm.contact.add', $contacts) as $addedContactResult) {
            $this->createdContactIds[] = $addedContactResult->getResult()[0];
            $cnt++;
        }
        $this->assertEquals(count($contacts), $cnt);
        $this->assertEquals(count($contacts), $this->serviceBuilder->getCRMScope()->contact()->countByFilter([
            'ORIGINATOR_ID' => $originatorId
        ]));

        // test batch with limit
        $readContactsId = [];
        foreach ($this->batch->getTraversableList('crm.contact.list',
            [],
            [
                'ORIGINATOR_ID' => $originatorId
            ],
            [
                'ID',
                'NAME',
                'ORIGINATOR_ID'
            ],
            $greaterThanDefaultPageSize / 2
        ) as $cnt => $itemContact) {
            $readContactsId[] = $itemContact['ID'];
        }
        $this->assertCount($greaterThanDefaultPageSize / 2, $readContactsId);
    }

    #[TestDox('test get contacts in batch mode with less than one page but only one batch query and limit argument')]
    public function testSingleBatchWithLessThanOnePageAndLimit(): void
    {
        $greaterThanDefaultPageSize = 40;
        $originatorId = Uuid::v7()->toRfc4122();
        // add contacts
        $contacts = [];
        for ($i = 0; $i < $greaterThanDefaultPageSize; $i++) {
            $contacts[] = [
                'fields' => [
                    'NAME' => 'name-' . $i,
                    'ORIGINATOR_ID' => $originatorId
                ]
            ];
        }
        $cnt = 0;
        foreach ($this->batch->addEntityItems('crm.contact.add', $contacts) as $addedContactResult) {
            $this->createdContactIds[] = $addedContactResult->getResult()[0];
            $cnt++;
        }
        $this->assertEquals(count($contacts), $cnt);
        $this->assertEquals(count($contacts), $this->serviceBuilder->getCRMScope()->contact()->countByFilter([
            'ORIGINATOR_ID' => $originatorId
        ]));

        // test batch with limit
        $readContactsId = [];
        foreach ($this->batch->getTraversableList('crm.contact.list',
            [],
            [
                'ORIGINATOR_ID' => $originatorId
            ],
            [
                'ID',
                'NAME',
                'ORIGINATOR_ID'
            ],
            $greaterThanDefaultPageSize / 2
        ) as $cnt => $itemContact) {
            $readContactsId[] = $itemContact['ID'];
        }
        $this->assertCount($greaterThanDefaultPageSize / 2, $readContactsId);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->batch = Fabric::getBatchService();
        $this->serviceBuilder = Fabric::getServiceBuilder();
    }

    public function tearDown(): void
    {
        if ($this->createdContactIds !== null) {
            foreach ($this->batch->deleteEntityItems('crm.contact.delete', $this->createdContactIds) as $result) {
            }
        }
    }
}