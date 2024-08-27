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

namespace Bitrix24\SDK\Services\CRM\Contact\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class ContactsResult
 *
 * @package Bitrix24\SDK\Services\CRM\Contact\Result
 */
class ContactsResult extends AbstractResult
{
    /**
     * @return ContactItemResult[]
     * @throws BaseException
     */
    public function getContacts(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new ContactItemResult($item);
        }

        return $res;
    }
}