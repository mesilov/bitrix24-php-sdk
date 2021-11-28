<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Contact\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\CRM\Contact\Service\ContactUserfield;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class ContactUserfieldUseCaseTest extends TestCase
{
    protected Contact $contactService;
    protected ContactUserfield $contactUserfieldService;
    protected int $contactUserfieldId;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers Contact::add
     */
    public function testOperationsWithUserfieldFromContactItem(): void
    {
        // get userfield metadata
        $ufMetadata = $this->contactUserfieldService->get($this->contactUserfieldId)->userfieldItem();
        $ufOriginalFieldName = $ufMetadata->getOriginalFieldName();
        $ufFieldName = $ufMetadata->FIELD_NAME;

        // add contact with uf value
        $fieldNameValue = 'test field value';
        $newContactId = $this->contactService->add(
            [
                'NAME'       => 'test contact',
                $ufFieldName => $fieldNameValue,
            ]
        )->getId();
        $contact = $this->contactService->get($newContactId)->contact();
        $this->assertEquals($fieldNameValue, $contact->getUserfieldByFieldName($ufOriginalFieldName));

        // update contact userfield value
        $newUfValue = 'test 2';
        $this->assertTrue(
            $this->contactService->update(
                $contact->ID,
                [
                    $ufFieldName => $newUfValue,
                ]
            )->isSuccess()
        );
        $updatedContact = $this->contactService->get($contact->ID)->contact();
        $this->assertEquals($newUfValue, $updatedContact->getUserfieldByFieldName($ufOriginalFieldName));
    }

    /**
     * @throws \Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNameIsTooLongException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function setUp(): void
    {
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
        $this->contactUserfieldService = Fabric::getServiceBuilder()->getCRMScope()->contactUserfield();

        $this->contactUserfieldId = $this->contactUserfieldService->add(
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
        $this->contactUserfieldService->delete($this->contactUserfieldId);
    }
}