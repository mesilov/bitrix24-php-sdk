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