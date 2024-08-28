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

namespace Bitrix24\SDK\Services\Telephony\Call\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Call\Result\TranscriptAttachedResult;
use Bitrix24\SDK\Services\Telephony\Common\TranscriptMessage;
use Bitrix24\SDK\Services\Telephony\Call\Service\Batch;
use Money\Money;
use Psr\Log\LoggerInterface;
#[ApiServiceMetadata(new Scope(['telephony']))]
class Call extends AbstractService
{
    public function __construct(
        readonly public Batch $batch,
        CoreInterface         $core,
        LoggerInterface       $logger
    )
    {
        parent::__construct($core, $logger);
    }

    /**
     * The method adds a call transcript.
     *
     * @param non-empty-string $callId
     * @param TranscriptMessage[] $messages
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_call_attachtranscription.php
     */
    #[ApiEndpointMetadata(
        'telephony.call.attachTranscription',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_call_attachtranscription.php',
        'The method adds a call transcript.'
    )]
    public function attachTranscription(
        string $callId,
        Money  $money,
        array  $messages
    ): TranscriptAttachedResult
    {
        $rawMessages = [];
        foreach ($messages as $message) {
            $rawMessages[] = [
                'SIDE' => $message->side->value,
                'START_TIME' => $message->startTime,
                'STOP_TIME' => $message->stopTime,
                'MESSAGE' => $message->message
            ];
        }

        return new TranscriptAttachedResult($this->core->call('telephony.call.attachTranscription', [
            'CALL_ID' => $callId,
            'COST' => $this->decimalMoneyFormatter->format($money),
            'COST_CURRENCY' => $money->getCurrency()->getCode(),
            'MESSAGES' => $rawMessages
        ]));
    }
}

















