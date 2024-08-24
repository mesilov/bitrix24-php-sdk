<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\UserConsent\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\UserConsent\Service\UserConsent;
use Bitrix24\SDK\Services\UserConsent\Service\UserConsentAgreement;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class UserConsentTest extends TestCase
{
    private UserConsent $userConsentService;

    private UserConsentAgreement $userConsentAgreementService;

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get agreements list')]
    public function testAdd(): void
    {
        // get agreement id
        $agreements = $this->userConsentAgreementService->list()->getAgreements();
        // empty agreement list
        if ($agreements === []) {
            $this->assertTrue(true);

            return;
        }

        $agreementId = $agreements[0]->ID;
        $addedItemResult = $this->userConsentService->add(
            [
                'agreement_id'  => $agreementId,
                'ip'            => '127.0.0.1',
                'origin_id'     => 'offline',
                'originator_id' => 'test@gmail.com',
            ]
        );
        $this->assertIsInt($addedItemResult->getId());
    }

    protected function setUp(): void
    {
        $this->userConsentService = Fabric::getServiceBuilder()->getUserConsentScope()->UserConsent();
        $this->userConsentAgreementService = Fabric::getServiceBuilder()->getUserConsentScope()->UserConsentAgreement();
    }
}