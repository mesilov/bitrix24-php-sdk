<?php

declare(strict_types=1);

/*
 * This file is part of the bitrix24-php-sdk package.
 *
 *  Kirill  Кhramov <k_hram@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Services\Telephony\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Result\CallAttachTranscriptionResult;
use Money\Money;


class Call extends AbstractService
{
    /**
     * The method adds a call transcript.
     *
     * @param string $callId
     * @param Money $callCosts
     * @param array<int, array<string,string>> $messages
     * @return \Bitrix24\SDK\Services\Telephony\Result\CallAttachTranscriptionResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_call_attachtranscription.php
     */
    public function attachTranscription(string $callId, Money $callCosts, array $messages): CallAttachTranscriptionResult
    {
        return new CallAttachTranscriptionResult(
            $this->core->call(
                'telephony.call.attachTranscription',
                [
                    'CALL_ID' => $callId,
                    'COST' => $this->decimalMoneyFormatter->format($callCosts),
                    'COST_CURRENCY' => $callCosts->getCurrency()->getCode(),
                    'MESSAGES' => $messages,
                ]
            )
        );
    }
}