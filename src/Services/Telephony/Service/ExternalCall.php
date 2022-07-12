<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallFinishResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallRecordResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallRegisterResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallHideResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallShowResult;


class ExternalCall extends  AbstractService{
    /**
     * The method registers a call in Bitrix24
     * @param array{
     * userPhoneInner?: string,
     * userId?: int,
     * userPhoneNumber?: string,
     * callStartDate?: string,
     * crmCreate?: int,
     * crmSource?: string,
     * crmEntityType?: string,
     * crmEntityId?: int,
     * showCardCall?: int,
     * callListId?: int,
     * outsideLineNumber?: string,
     * typeCall?: int,
     * } $fields
     *
     *
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalCallRegisterResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_register.php
     */

    public function registerCall(array $fields): ExternalCallRegisterResult
    {
        return new ExternalCallRegisterResult(
            $this->core->call(
                    'telephony.externalcall.register',
                    $fields,

            )
        );
    }

    /**
     * This method displays a call ID screen to the user.
     *
     *
     * @param string $callId
     * @param int $userId
     *
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalCallShowResult
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_show.php
     */
    public function showCallCard(string $callId, int $userId):ExternalCallShowResult{
        return new ExternalCallShowResult(
            $this->core->call(
                'telephony.externalcall.show',
                [
                   'CALL_ID'=>$callId,
                    'USER_ID'=>$userId,
                ]
            )
        );
    }

    /**
     * This method hides call information window.
     *
     *
     * @param string $callId
     * @param int $userId
     *
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalCallHideResult
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_hide.php
     */
    public function hideCallCard(string $callId, int $userId):ExternalCallHideResult{
        return new ExternalCallHideResult(
            $this->core->call(
                'telephony.externalcall.hide',
                [
                    'CALL_ID'=>$callId,
                    'USER_ID'=>$userId,
                ]
            )
        );
    }

    /**
     * Method completes the call, registers it in the statistics and hides the call ID screen from the user.
     * @param string $callId
     * @param int $userId
     * @param int $durationCall
     * @param float $costCall
     * @param string $costCurrency
     * @param string $statusCode
     * @param string $failedReason
     * @param string $recordUrlFile
     * @param int $vote
     * @param int $addMessageToChat
     *
     * @return ExternalCallFinishResult
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_finish.php
     */
    public function finishСall(string $callId, int $userId, int $durationCall, float $costCall, string $costCurrency,
                                string $statusCode, string $failedReason, string $recordUrlFile, int $vote, int $addMessageToChat):ExternalCallFinishResult
    {
        return new ExternalCallFinishResult(
            $this->core->call(
                'telephony.externalcall.finish',
                [
                    'CALL_ID'=>$callId,
                    'USER_ID'=>$userId,
                    'DURATION'=>$durationCall,
                    'COST'=>$costCall,
                    'COST_CURRENCY'=>$costCurrency,
                    'STATUS_CODE'=>$statusCode,
                    'FAILED_REASON'=>$failedReason,
                    'RECORD_URL'=>$recordUrlFile,
                    'VOTE'=>$vote,
                    'ADD_TO_CHAT'=>$addMessageToChat,
                ]
            )
        );
    }

    /**
     * This method connects a record to a finished call and to the call Activity.
     *
     * @param string $callId
     * @param string $fileName
     * @param string $fileContent
     * @param string $recordUrl
     *
     * @return ExternalCallRecordResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalCall_attachRecord.php
     */
    public function attachRecord(string $callId, string $fileName, string $fileContent,string $recordUrl):ExternalCallRecordResult
    {
        return new ExternalCallRecordResult(
            $this->core->call(
                'telephony.externalCall.attachRecord',
                [
                    'CALL_ID'=>$callId,
                    'FILENAME'=>$fileName,
                    'FILE_CONTENT'=>$fileContent,
                    'RECORD_URL'=>$recordUrl,
                ]
            )
        );
    }
}