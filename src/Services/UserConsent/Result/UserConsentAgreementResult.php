<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\UserConsent\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class UserConsentAgreementResult extends AbstractResult
{
    /**
     * @throws BaseException
     */
    public function agreement(): UserConsentAgreementItemResult
    {
        return new UserConsentAgreementItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}