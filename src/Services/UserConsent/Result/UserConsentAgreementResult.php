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