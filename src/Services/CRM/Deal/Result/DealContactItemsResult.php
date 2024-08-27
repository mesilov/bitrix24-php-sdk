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

namespace Bitrix24\SDK\Services\CRM\Deal\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class DealContactItemsResult
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Result
 */
class DealContactItemsResult extends AbstractResult
{
    /**
     * @return DealContactItemResult[]
     * @throws BaseException
     */
    public function getDealContacts(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $dealContact) {
            $res[] = new DealContactItemResult($dealContact);
        }

        return $res;
    }
}