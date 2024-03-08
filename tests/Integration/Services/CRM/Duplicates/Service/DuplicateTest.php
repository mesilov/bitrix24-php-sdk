<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Duplicates\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\CRM\Lead\Service\Lead;
use Bitrix24\SDK\Services\CRM\Duplicates\Service\EntityType;
use Bitrix24\SDK\Services\CRM\Duplicates\Service\Duplicate;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class DuplicateTest extends TestCase
{
    protected Contact $contactService;
    // protected Company $companyService;
    protected Lead $leadService;
    protected Duplicate $duplicate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
        $this->leadService = Fabric::getServiceBuilder()->getCRMScope()->lead();
        // $this->companyService = Fabric::getServiceBuilder()->getCRMScope()->company(); //нет такого
        $this->duplicate = Fabric::getServiceBuilder()->getCRMScope()->duplicate();
    }

    /**
     * Комплексное тестирование методов дубликатов по лидам\контактам\(todo)компаниям
     * 
     * @dataProvider duplicateDataProvider
     * @param int $numberOfEntities Количество создаваемых сущностей
     * @param bool $expectNoMatches Ожидаем ли отсутствие совпадений
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Duplicates\Service\Duplicate
     * @covers \Bitrix24\SDK\Services\CRM\Duplicates\Result\DuplicateResult
     */
    public function testEntityDuplicates(EntityType $entityType, int $numberOfEntities, bool $expectNoMatches): void
    {
        $email = sprintf('%s@example.com', time());
        $phone = sprintf('+7444%07d', substr((string)time(), -7));
        $createdEntityIds = [];

        if (!$expectNoMatches) {
            for ($i = 0; $i < $numberOfEntities; $i++) {
                $createdEntityIds[] = $this->createEntity($entityType, $email, $phone, $i);
            }
        }

        $this->runDuplicateCheck('email', $email, $createdEntityIds, $expectNoMatches, $entityType);
        $this->runDuplicateCheck('phone', $phone, $createdEntityIds, $expectNoMatches, $entityType);

        $this->cleanUpEntities($entityType, $createdEntityIds);
    }

    private function createEntity($entityType, $email, $phone, $index): int
    {
        $data = [
            'NAME' => 'Test' . $index,
            'EMAIL' => [['VALUE' => $email, 'TYPE' => 'WORK']],
            'PHONE' => [['VALUE' => $phone, 'TYPE' => 'WORK']]
        ];

        switch ($entityType) {
            case EntityType::Contact:
                return $this->contactService->add($data)->getId();
            case EntityType::Company:
                // return $this->companyService->add($data)->getId();
            case EntityType::Lead:
                return $this->leadService->add($data)->getId();
            default:
                throw new \Exception("Unsupported entity type: $entityType");
        }
    }

    private function runDuplicateCheck(string $method, string $value, array $createdEntityIds, bool $expectNotFound, EntityType $entityType): void
    {
        $result = $method === 'email' ? $this->duplicate->findByEmail([$value], $entityType) : $this->duplicate->findByPhone([$value], $entityType);
        $expectNotFound ? $this->assertResultNotFound($result, $entityType) : $this->assertResultState($result, $createdEntityIds, $entityType);
    }
    private function assertResultNotFound($result, EntityType $entityType): void
    {
        if ($entityType === EntityType::Contact) {
            $this->assertFalse($result->hasOneContact());
            $this->assertFalse($result->hasDuplicateContacts());
            $this->assertCount(0, $result->getContactsId());
        }

        $this->assertFalse($result->hasOne($entityType));
        $this->assertFalse($result->hasDuplicates($entityType));
        $this->assertFalse($result->hasMatches($entityType));
        $this->assertFalse($result->hasAnyMatches());
        $this->assertCount(0, $result->getEntityIds($entityType));
        $this->assertNull($result->getMatchId($entityType, "desc"));
        $this->assertNull($result->getMatchIdByPriority([$entityType]));
    }


    private function assertResultState($result, array $createdEntityIds, EntityType $entityType): void
    {
        $hasDuplicates = count($createdEntityIds) > 1;
        $hasOne = count($createdEntityIds) === 1;

        // Проверка для контактов
        if ($entityType === EntityType::Contact) {
            $this->assertEquals($hasOne, $result->hasOneContact());
            $this->assertEquals($hasDuplicates, $result->hasDuplicateContacts());
            $this->assertEquals($createdEntityIds, $result->getContactsId());
        }

        // Проверка для всех сущностей
        $this->assertEquals($hasOne, $result->hasOne($entityType));
        $this->assertEquals($hasDuplicates, $result->hasDuplicates($entityType));
        $this->assertTrue($result->hasMatches($entityType));
        $this->assertTrue($result->hasAnyMatches());

        $this->assertEquals($createdEntityIds, $result->getEntityIds($entityType));

        // Проверка сортировки ID
        if ($hasOne || $hasDuplicates) {
            $expectedDescId = max($createdEntityIds);
            $expectedAscId = min($createdEntityIds);

            $this->assertEquals($expectedDescId, $result->getMatchId($entityType, "desc"), "ID in DESC order does not match the expected.");
            $this->assertEquals($expectedAscId, $result->getMatchId($entityType, "asc"), "ID in ASC order does not match the expected.");
        }

        foreach (['desc', 'asc'] as $sortOrder) {
            $matchByPriority = $result->getMatchIdByPriority($entityTypesOrder = [EntityType::Lead, EntityType::Contact, EntityType::Company], $sortOrder);
            if ($matchByPriority !== null) {
                $this->assertNotNull($matchByPriority);
                $this->assertContains($matchByPriority['id'], $createdEntityIds, "Match ID by priority for $sortOrder does not match one of the created entity IDs.");

                if ($sortOrder === 'desc') {
                    $this->assertEquals($expectedDescId, $matchByPriority['id'], "Match ID by priority for DESC does not match the expected.");
                } else {
                    $this->assertEquals($expectedAscId, $matchByPriority['id'], "Match ID by priority for ASC does not match the expected.");
                }
            }
        }
    }
    private function cleanUpEntities($entityType, array $entityIds): void
    {
        foreach ($entityIds as $entityId) {
            switch ($entityType) {
                case EntityType::Contact:
                    $this->contactService->delete($entityId);
                    break;
                case EntityType::Company:
                    // $this->companyService->delete($entityId);
                    break;
                case EntityType::Lead:
                    $this->leadService->delete($entityId);
                    break;
            }
        }
    }

    public static function duplicateDataProvider(): array
    {
        return [
            // Test cases for contacts
            'One contact, no duplicates' => [EntityType::Contact, 1, false],
            'Two contacts, have duplicates' => [EntityType::Contact, 2, false],
            'Three contacts, have duplicates' => [EntityType::Contact, 3, false],
            'Contacts not found' => [EntityType::Contact, 0, true],
            // Test cases for companies (no service)
            // 'One company, no duplicates' => [EntityType::Company, 1, false],
            // 'Two companies, have duplicates' => [EntityType::Company, 2, false],
            // 'Three companies, have duplicates' => [EntityType::Company, 3, false],
            // 'Companies not found' => [EntityType::Company, 0, true],
            // Test cases for leads
            'One lead, no duplicates' => [EntityType::Lead, 1, false],
            'Two leads, have duplicates' => [EntityType::Lead, 2, false],
            'Three leads, have duplicates' => [EntityType::Lead, 3, false],
            'Leads not found' => [EntityType::Lead, 0, true],
        ];
    }


     /**
     * @dataProvider priorityOrderProvider
     * @param array $priorityOrders
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Duplicates\Result\DuplicateResult::getMatchIdByPriority
     */
    public function testGetMatchIdByPriorityWithDataProvider(array $priorityOrders)
    {
        // Шаг 1: Создание сущностей с одинаковыми контактными данными
        $email = sprintf('%s@example.com', time());
        $phone = sprintf('+7444%07d', substr((string)time(), -7));

        $entities = [
            'Lead' => $this->createEntity(EntityType::Lead, $email, $phone, 0),
            'Contact' => $this->createEntity(EntityType::Contact, $email, $phone, 1),
            // 'Company' => $this->createEntity(EntityType::Company, $email, $phone, 2),
        ];

        // Шаг 2: Поиск дубликатов без указания EntityType
        $duplicateResult = $this->duplicate->findByPhone([$phone], null);

        // Шаг 3: Проверка getMatchIdByPriority с разными приоритетами из $priorityOrders
        foreach ($priorityOrders as $priorityOrder) {
            $match = $duplicateResult->getMatchIdByPriority($priorityOrder, 'desc');
            $expectedEntity = reset($priorityOrder); // Первый в приоритете тип сущности
            $expectedId = $entities[$expectedEntity->name];

            $this->assertNotNull($match);
            $this->assertEquals($expectedId, $match['id']);
            $this->assertEquals($expectedEntity, $match['entityType']);
            $this->assertEquals($expectedEntity->value, $match['entityTypeValue']);
        }

        // Очистка созданных сущностей
        foreach ($entities as $entityType => $id) {
            $this->cleanUpEntities($entityType, [$id]);
        }
    }

    /**
     * Data provider for testGetMatchIdByPriority.
     */
    public static function priorityOrderProvider()
    {
        return [
            'Lead > Contact > Company' => [[[EntityType::Lead, EntityType::Contact, EntityType::Company]]],
            'Contact > Lead > Company' => [[[EntityType::Contact, EntityType::Lead, EntityType::Company]]],
            // 'Company > Lead > Contact' => [[[EntityType::Contact, EntityType::Lead, EntityType::Company]]],
        ];
    }


    /**
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Duplicates\Service\Duplicate::findByEmail
     */
    public function testDuplicatesByEmailNotFound(): void
    {
        $res = $this->duplicate->findByEmail([sprintf('%s@gmail.com', time())], null);
        $this->assertFalse($res->hasDuplicateContacts());
        $this->assertFalse($res->hasOneContact());
        $this->assertCount(0, $res->getContactsId());
    }

    /**
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Duplicates\Service\Duplicate::findByEmail
     */
    public function testDuplicatesByEmailOneItemFound(): void
    {
        $email = sprintf('%s@gmail.com', time());
        $b24ContactId = $this->contactService->add([
            'NAME' => 'Test',
            'LAST_NAME' => 'Test',
            'EMAIL' => [
                [
                    'VALUE' => $email,
                    'TYPE' => 'WORK'
                ]
            ]
        ])->getId();

        $res = $this->duplicate->findByEmail([$email], null);
        $this->assertFalse($res->hasDuplicateContacts());
        $this->assertTrue($res->hasOneContact());
        $this->assertCount(1, $res->getContactsId());
    }

    /**
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Duplicates\Service\Duplicate::findByPhone
     */
    public function testDuplicatesByPhoneNotFound(): void
    {
        $res = $this->duplicate->findByPhone([sprintf('+1%s', time())], null);
        $this->assertFalse($res->hasDuplicateContacts());
        $this->assertFalse($res->hasOneContact());
        $this->assertCount(0, $res->getContactsId());
    }


    
}