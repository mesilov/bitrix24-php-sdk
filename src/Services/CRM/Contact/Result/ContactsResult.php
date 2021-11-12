<?php


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
        foreach ($this->getCoreResponse()->getResponseData()->getResult()->getResultData() as $item) {
            $res[] = new ContactItemResult($item);
        }

        return $res;
    }
}