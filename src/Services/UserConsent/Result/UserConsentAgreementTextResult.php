<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\UserConsent\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class UserConsentAgreementTextResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\UserConsent\Result\UserConsentAgreementTextItemResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function text(): UserConsentAgreementTextItemResult
    {
        return new UserConsentAgreementTextItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}