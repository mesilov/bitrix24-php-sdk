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

class UserConsentAgreementsResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\UserConsent\Result\UserConsentAgreementItemResult[]
     * @throws BaseException
     */
    public function getAgreements(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new UserConsentAgreementItemResult($item);
        }

        return $res;
    }
}