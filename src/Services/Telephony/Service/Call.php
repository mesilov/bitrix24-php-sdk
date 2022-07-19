<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Result\CallAttachTranscriptionResult;


class Call extends AbstractService
{
    /**
     * The method adds a call transcript.
     *
     * @param string $call_id
     * @param float $cost
     * @param string $cost_currency
     * @param array $messages
     * @return \Bitrix24\SDK\Services\Telephony\Result\CallAttachTranscriptionResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_call_attachtranscription.php
     */
    public function attachTranscription(string $call_id , float $cost, string $cost_currency, array $messages): CallAttachTranscriptionResult
    {
        return new CallAttachTranscriptionResult(
            $this->core->call(
                'telephony.call.attachTranscription',
                [
                    'CALL_ID' => $call_id,
                    'COST'=> $cost,
                    'COST_CURRENCY'=>$cost_currency,
                    'MESSAGES'=>$messages,
                ]
            )
        );
    }
}