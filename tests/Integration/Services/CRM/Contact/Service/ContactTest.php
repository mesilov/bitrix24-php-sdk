<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Contact\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\EmailValueType;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\InstantMessengerValueType;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\PhoneValueType;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\WebsiteValueType;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;
use Bitrix24\SDK\Core;
use Faker;

/**
 * Class ContactTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Contact\Service
 */
class ContactTest extends TestCase
{
    protected Contact $contactService;
    protected Faker\Generator $faker;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Contact::add
     */
    public function testAdd(): void
    {
        self::assertGreaterThanOrEqual(1, $this->contactService->add(['NAME' => 'test contact'])->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Contact::delete
     */
    public function testDelete(): void
    {
        self::assertTrue($this->contactService->delete($this->contactService->add(['NAME' => 'test contact'])->getId())->isSuccess());
    }

    /**
     * @covers Contact::fields
     * @throws BaseException
     * @throws TransportException
     */
    public function testFields(): void
    {
        self::assertIsArray($this->contactService->fields()->getFieldsDescription());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Contact::get
     */
    public function testGet(): void
    {
        self::assertGreaterThan(
            1,
            $this->contactService->get($this->contactService->add(['NAME' => 'test contact'])->getId())->contact()->ID
        );
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Contact::list
     */
    public function testList(): void
    {
        $this->contactService->add(['NAME' => 'test contact']);
        self::assertGreaterThanOrEqual(1, $this->contactService->list([''], [''], ['ID', 'NAME'], 0)->getContacts());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Contact::update
     */
    public function testUpdate(): void
    {
        $contact = $this->contactService->add(['NAME' => 'test']);
        $newName = 'test2';

        self::assertTrue($this->contactService->update($contact->getId(), ['NAME' => $newName], [])->isSuccess());
        self::assertEquals($newName, $this->contactService->get($contact->getId())->contact()->NAME);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testCountByFilter(): void
    {
        $totalBefore = $this->contactService->countByFilter();

        $newContactsCount = 70;

        $contacts = [];
        for ($i = 1; $i <= $newContactsCount; $i++) {
            $contacts[] = ['NAME' => 'name-' . $i];
        }

        foreach ($this->contactService->batch->add($contacts) as $item) {
        }

        $totalAfter = $this->contactService->countByFilter();

        $this->assertEquals($totalBefore + $newContactsCount, $totalAfter);
    }

    /**
     * @return void
     * @covers Contact::get
     * @covers Contact::add
     * @throws Core\Exceptions\TransportException
     * @throws Core\Exceptions\BaseException
     */
    public function testGetEmail(): void
    {
        $email = $this->faker->email();
        $this->assertEquals($email,
            $this->contactService->get(
                $this->contactService->add([
                    'NAME' => $this->faker->name(),
                    'EMAIL' => [
                        [
                            'VALUE' => $email,
                            'VALUE_TYPE' => EmailValueType::work->name,
                        ]
                    ],
                ])->getId())->contact()->EMAIL[0]->VALUE);
    }

    /**
     * @return void
     * @covers Contact::get
     * @covers Contact::add
     * @throws Core\Exceptions\TransportException
     * @throws Core\Exceptions\BaseException
     */
    public function testGetPhone(): void
    {
        $phone = $this->faker->e164PhoneNumber();
        $this->assertEquals($phone,
            $this->contactService->get(
                $this->contactService->add([
                    'NAME' => $this->faker->name(),
                    'PHONE' => [
                        [
                            'VALUE' => $phone,
                            'VALUE_TYPE' => PhoneValueType::work->name,
                        ]
                    ],
                ])->getId())->contact()->PHONE[0]->VALUE);
    }

    /**
     * @return void
     * @covers Contact::get
     * @covers Contact::add
     * @throws Core\Exceptions\TransportException
     * @throws Core\Exceptions\BaseException
     */
    public function testGetInstantMessenger(): void
    {
        $phone = $this->faker->e164PhoneNumber();
        $this->assertEquals($phone,
            $this->contactService->get(
                $this->contactService->add([
                    'NAME' => $this->faker->name(),
                    'IM' => [
                        [
                            'VALUE' => $phone,
                            'VALUE_TYPE' => InstantMessengerValueType::telegram->name,
                        ]
                    ],
                ])->getId())->contact()->IM[0]->VALUE);
    }

    /**
     * @return void
     * @covers Contact::get
     * @covers Contact::add
     * @throws Core\Exceptions\TransportException
     * @throws Core\Exceptions\BaseException
     */
    public function testGetWebsite(): void
    {
        $url = $this->faker->url();
        $this->assertEquals($url,
            $this->contactService->get(
                $this->contactService->add([
                    'NAME' => $this->faker->name(),
                    'WEB' => [
                        [
                            'VALUE' => $url,
                            'VALUE_TYPE' => WebsiteValueType::work,
                        ]
                    ],
                ])->getId())->contact()->WEB[0]->VALUE);
    }

    public function setUp(): void
    {
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
        $this->faker = Faker\Factory::create();
    }
}