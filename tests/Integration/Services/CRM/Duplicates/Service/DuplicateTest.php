<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Duplicates\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\CRM\Duplicates\Service\Duplicate;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class DuplicateTest extends TestCase
{
    protected Contact $contactService;
    protected Duplicate $duplicate;

    /**
     * @return void
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Duplicates\Service\Duplicate::findByEmail
     */
    public function testDuplicatesByEmailNotFound(): void
    {
        $res = $this->duplicate->findByEmail([sprintf('%s@gmail.com', time())]);
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

        $res = $this->duplicate->findByEmail([$email]);
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
        $res = $this->duplicate->findByPhone([sprintf('+1%s', time())]);
        $this->assertFalse($res->hasDuplicateContacts());
        $this->assertFalse($res->hasOneContact());
        $this->assertCount(0, $res->getContactsId());
    }


    public function setUp(): void
    {
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
        $this->duplicate = Fabric::getServiceBuilder()->getCRMScope()->duplicate();

    }
}