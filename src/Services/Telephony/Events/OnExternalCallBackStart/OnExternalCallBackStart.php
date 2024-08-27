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

namespace Bitrix24\SDK\Services\Telephony\Events\OnExternalCallBackStart;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnExternalCallBackStart extends AbstractEventRequest
{
    public const CODE = 'ONEXTERNALCALLBACKSTART';

    public function getPayload(): OnExternalCallBackStartEventPayload
    {
        return new OnExternalCallBackStartEventPayload($this->eventPayload['data']);
    }
}