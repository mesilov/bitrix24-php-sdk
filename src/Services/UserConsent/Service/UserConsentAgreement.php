<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\UserConsent\Service;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\UserConsent\Result\UserConsentAgreementsResult;
use Bitrix24\SDK\Services\UserConsent\Result\UserConsentAgreementTextResult;

class UserConsentAgreement extends AbstractService
{
    /**
     * Get user consent agreement list
     *
     * @return \Bitrix24\SDK\Services\UserConsent\Result\UserConsentAgreementsResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function list(): UserConsentAgreementsResult
    {
        return new UserConsentAgreementsResult($this->core->call('userconsent.agreement.list'));
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
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