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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\ExternalCallFinishedItemResult;

class SipLineStatusResult extends AbstractResult
{
    public function getStatus(): SipLineStatusItemResult
    {
        return new SipLineStatusItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}