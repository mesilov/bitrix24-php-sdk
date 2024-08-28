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

use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class ContactResult
 *
 * @package Bitrix24\SDK\Services\CRM\Contact\Result
 */
class ContactResult extends AbstractResult
{
    public function contact(): ContactItemResult
    {
        return new ContactItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}