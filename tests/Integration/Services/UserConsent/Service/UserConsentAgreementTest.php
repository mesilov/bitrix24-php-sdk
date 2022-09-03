<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\UserConsent\Service;

use Bitrix24\SDK\Services\UserConsent\Service\UserConsentAgreement;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

class UserConsentAgreementTest extends TestCase
{
    private UserConsentAgreement $userConsentAgreementService;

    /**
     * @covers  UserConsentAgreement::list
     * @testdox test get agreements list
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testList(): void
    {
        $this->assertIsArray($this->userConsentAgreementService->list()->getAgreements());
    }

    /**
     * @covers  UserConsentAgreement::text
     * @testdox test get agreements list
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testText(): void
    {
        // get agreement id
        $agreements = $this->userConsentAgreementService->list()->getAgreements();
        // empty agreement list
        if (count($agreements) === 0) {
            $this->assertTrue(true);

            return;
        }
        $agreementId = $agreements[0]->ID;
        $agreementText = $this->userConsentAgreementService->text($agreementId, [
            'button_caption' => 'Button call to action title',
            'fields'         => 'fields collection: email, phone',
        ])->text();

        $this->assertNotNull($agreementText->TEXT);
        $this->assertNotNull($agreementText->LABEL);
    }

    public function setUp(): void
    {
        $this->userConsentAgreementService = Fabric::getServiceBuilder()->getUserConsentScope()->UserConsentAgreement();
    }
}