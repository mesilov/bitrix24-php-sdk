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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\User\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class VoximplantUserSettingsResult extends AbstractResult
{
    /**
     * @return VoximplantUserSettingsItemResult[]
     * @throws BaseException
     */
    public function getUsers(): array
    {
        $items = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $user) {
            $items[] = new VoximplantUserSettingsItemResult($user);
        }

        return $items;
    }
}