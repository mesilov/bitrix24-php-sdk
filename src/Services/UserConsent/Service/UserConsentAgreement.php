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

namespace Bitrix24\SDK\Services\UserConsent\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\UserConsent\Result\UserConsentAgreementsResult;
use Bitrix24\SDK\Services\UserConsent\Result\UserConsentAgreementTextResult;
#[ApiServiceMetadata(new Scope(['userconsent']))]
class UserConsentAgreement extends AbstractService
{
    /**
     * Get user consent agreement list
     *
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'userconsent.agreement.list',
        'https://training.bitrix24.com/rest_help/userconsent/userconsent_consent_add.php',
        'Add the received user agreement consent'
    )]
    public function list(): UserConsentAgreementsResult
    {
        return new UserConsentAgreementsResult($this->core->call('userconsent.agreement.list'));
    }

    /**
     * @throws TransportException
     * @throws InvalidArgumentException
     * @throws BaseException
     */
    #[ApiEndpointMetadata(
        'userconsent.agreement.text',
        'https://training.bitrix24.com/rest_help/userconsent/userconsent_agreement_text.php',
        'This method gets the agreement text'
    )]
    public function text(int $agreementId, array $replace): UserConsentAgreementTextResult
    {
        if (!array_key_exists('button_caption', $replace)) {
            throw new InvalidArgumentException('field «button_caption» not found in argument replace ');
        }

        if (!array_key_exists('fields', $replace)) {
            throw new InvalidArgumentException('field «fields» not found in argument replace');
        }

        return new UserConsentAgreementTextResult(
            $this->core->call('userconsent.agreement.text', [
                'id'      => $agreementId,
                'replace' => $replace,
            ])
        );
    }
}