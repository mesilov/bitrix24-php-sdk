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

namespace Bitrix24\SDK\Tests\Integration\Services\UserConsent\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\UserConsent\Service\UserConsentAgreement;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class UserConsentAgreementTest extends TestCase
{
    private UserConsentAgreement $userConsentAgreementService;

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get agreements list')]
    public function testList(): void
    {
        $this->assertIsArray($this->userConsentAgreementService->list()->getAgreements());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    #[TestDox('test get agreements list')]
    public function testText(): void
    {
        // get agreement id
        $agreements = $this->userConsentAgreementService->list()->getAgreements();
        // empty agreement list
        if ($agreements === []) {
            $this->assertTrue(true);

            return;
        }

        $agreementId = $agreements[0]->ID;
        $userConsentAgreementTextItemResult = $this->userConsentAgreementService->text($agreementId, [
            'button_caption' => 'Button call to action title',
            'fields'         => 'fields collection: email, phone',
        ])->text();

        $this->assertNotNull($userConsentAgreementTextItemResult->TEXT);
        $this->assertNotNull($userConsentAgreementTextItemResult->LABEL);
    }

    protected function setUp(): void
    {
        $this->userConsentAgreementService = Fabric::getServiceBuilder()->getUserConsentScope()->UserConsentAgreement();
    }
}