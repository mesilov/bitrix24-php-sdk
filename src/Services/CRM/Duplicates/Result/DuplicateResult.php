<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Duplicates\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class DuplicateResult extends AbstractResult
{
    public function hasDuplicateContacts(): bool
    {
        if (!array_key_exists('CONTACT', $this->getCoreResponse()->getResponseData()->getResult())) {
            return false;
        }

        if (count($this->getCoreResponse()->getResponseData()->getResult()['CONTACT']) > 1) {
            return true;
        }

        return false;
    }

    public function hasOneContact(): bool
    {
        if (!array_key_exists('CONTACT', $this->getCoreResponse()->getResponseData()->getResult())) {
            return false;
        }

        if (count($this->getCoreResponse()->getResponseData()->getResult()['CONTACT']) === 1) {
            return true;
        }

        return false;
    }

    /**
     * @return array<int>
     * @throws BaseException
     */
    public function getContactsId(): array
    {
        if (!array_key_exists('CONTACT', $this->getCoreResponse()->getResponseData()->getResult())) {
            return [];
        }

        return $this->getCoreResponse()->getResponseData()->getResult()['CONTACT'];
    }
}