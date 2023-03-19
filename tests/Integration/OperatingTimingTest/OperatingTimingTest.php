<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\OperatingTimingTest;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\ServiceBuilder;
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

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testOperatingTiming()
    {
        $PhoneNumWorkMas = [];
        $PhoneNumHomeMas = [];
        $masContacts = [];
        for($i=0; $i<5; $i++){
            $phoneNumberWork = sprintf('+7%s', time());
            $phoneNumberHome = sprintf('%s', microtime());
            $phoneNumberHome = implode("-",str_split(substr($phoneNumberHome,2,-13),2));
            $masContacts[] = [
                'NAME' => sprintf('first_%s', time()),
                'SECOND' => sprintf('second_%s', time()),
                'PHONE' => [
                    [
                        'VALUE' => $phoneNumberWork,
                        'VALUE_TYPE' => 'WORK'
                    ],
                    [
                        'VALUE' => $phoneNumberHome,
                        'VALUE_TYPE' => 'HOME'
                    ]
                ]
            ];

        }
        foreach ($masContacts as $contact){
            var_dump($contact);
            $contactId[] = $this->contactService->add($contact)->getId();
            foreach ($contactId as $id){
                $contactUpdate= $this->contactService->update($id,['PHONE'[0] => '']);
            }

            self::assertGreaterThanOrEqual(1,$contactId);
        }
        var_dump($contactId);


    }

    public function setUp(): void
    {
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }
}