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


namespace Bitrix24\SDK\Services\Telephony\Events;


use Bitrix24\SDK\Application\Requests\Events\EventInterface;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Services\Telephony\Events\OnExternalCallBackStart\OnExternalCallBackStart;
use Bitrix24\SDK\Services\Telephony\Events\OnExternalCallStart\OnExternalCallStart;
use Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallEnd\OnVoximplantCallEnd;
use Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallInit\OnVoximplantCallInit;
use Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallStart\OnVoximplantCallStart;
use Symfony\Component\HttpFoundation\Request;

readonly class TelephonyEventsFabric
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(Request $request): ?EventInterface
    {
        $eventPayload = $request->request->all();
        if (!array_key_exists('event', $eventPayload)) {
            throw new InvalidArgumentException('«event» key not found in event payload');
        }

        return match ($eventPayload['event']) {
            OnExternalCallBackStart::CODE => new OnExternalCallBackStart($request),
            OnExternalCallStart::CODE => new OnExternalCallStart($request),
            OnVoximplantCallEnd::CODE => new OnVoximplantCallEnd($request),
            OnVoximplantCallInit::CODE => new OnVoximplantCallInit($request),
            OnVoximplantCallStart::CODE => new OnVoximplantCallStart($request),
            default => null,
        };
    }
}