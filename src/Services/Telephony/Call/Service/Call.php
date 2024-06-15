<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Call\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\FileNotFoundException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\UserInterfaceDialogCallResult;
use Bitrix24\SDK\Infrastructure\Filesystem\Base64Encoder;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Call\Result\TranscriptAttachedResult;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\TelephonyCallStatusCode;
use Bitrix24\SDK\Services\Telephony\Common\TranscriptMessage;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\CallRecordUploadUrlResult;
use Bitrix24\SDK\Services\Telephony\Call\Service\Batch;
use Carbon\CarbonImmutable;
use Money\Money;
use Psr\Log\LoggerInterface;

class Call extends AbstractService
{
    public function __construct(
        readonly public Batch $batch,
        CoreInterface         $core,
        LoggerInterface       $log
    )
    {
        parent::__construct($core, $log);
    }

    /**
     * The method adds a call transcript.
     *
     * @param non-empty-string $callId
     * @param Money $cost
     * @param TranscriptMessage[] $messages
     * @return TranscriptAttachedResult
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_call_attachtranscription.php
     */
    public function attachTranscription(
        string $callId,
        Money  $cost,
        array  $messages
    ): TranscriptAttachedResult
    {
        $rawMessages = [];
        foreach ($messages as $item) {
            $rawMessages[] = [
                'SIDE' => $item->side->value,
                'START_TIME' => $item->startTime,
                'STOP_TIME' => $item->stopTime,
                'MESSAGE' => $item->message
            ];
        }
        return new TranscriptAttachedResult($this->core->call('telephony.call.attachTranscription', [
            'CALL_ID' => $callId,
            'COST' => $this->decimalMoneyFormatter->format($cost),
            'COST_CURRENCY' => $cost->getCurrency()->getCode(),
            'MESSAGES' => $rawMessages
        ]));
    }
}

















