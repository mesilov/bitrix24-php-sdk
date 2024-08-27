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

namespace Bitrix24\SDK\Services\CRM\Lead\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class LeadsResult
 *
 * @package Bitrix24\SDK\Services\CRM\Lead\Result
 */
class LeadsResult extends AbstractResult
{
    /**
     * @return LeadItemResult[]
     * @throws BaseException
     */
    public function getLeads(): array
    {
        $items = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $items[] = new LeadItemResult($item);
        }

        return $items;
    }
}