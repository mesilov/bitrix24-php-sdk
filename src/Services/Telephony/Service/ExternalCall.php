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
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallFinishResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallRecordResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallRegisterResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallHideResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallSearchCrmEntitiesResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallShowResult;


class ExternalCall extends AbstractService
{
    /**
     * The method registers a call in Bitrix24
     *
     * @param array{
     * USER_PHONE_INNER?: string,
     * USER_ID?: int,
     * PHONE_NUMBER?: string,
     * CALL_START_DATE?: string,
     * CRM_CREATE?: int,
     * CRM_SOURCE?: string,
     * CRM_ENTITY_TYPE?: string,
     * CRM_ENTITY_ID?: int,
     * SHOW?: int,
     * CALL_LIST_ID?: int,
     * LINE_NUMBER?: string,
     * TYPE?: int,
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
    public function show(string $callId, int $userId): ExternalCallShowResult
    {
        return new ExternalCallShowResult(
            $this->core->call(
                'telephony.externalcall.show',
                [
                    'CALL_ID' => $callId,
                    'USER_ID' => $userId,
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
    public function hide(string $callId, int $userId): ExternalCallHideResult
    {
        return new ExternalCallHideResult(
            $this->core->call(
                'telephony.externalcall.hide',
                [
                    'CALL_ID' => $callId,
                    'USER_ID' => $userId,
                ]
            )
        );
    }

    /**
     * Method completes the call, registers it in the statistics and hides the call ID screen from the user.
     *
     * @param array{
     *   CALL_ID?: string,
     *   USER_ID?: int,
     *   DURATION?: int,
     *   COST?: double,
     *   COST_CURRENCY?: string,
     *   STATUS_CODE?: string,
     *   FAILED_REASON?: string,
     *   RECORD_URL?: string,
     *   VOTE?: int,
     *   ADD_TO_CHAT?: int,
     *  } $fields
     *
     * @return ExternalCallFinishResult
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_finish.php
     */
    public function finish(array $fields): ExternalCallFinishResult
    {
        return new ExternalCallFinishResult(
            $this->core->call(
                'telephony.externalcall.finish',
                $fields
            )
        );
    }

    /**
     * This method connects a record to a finished call and to the call Activity.
     *
     * @param string $callId
     * @param string $fileName
     * @param string $fileContent
     * @param string|null $recordUrl
     *
     * @return ExternalCallRecordResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalCall_attachRecord.php
     */
    public function attachRecord(string $callId, string $fileName, string $fileContent, ?string $recordUrl = null): ExternalCallRecordResult
    {
        return new ExternalCallRecordResult(
            $this->core->call(
                'telephony.externalCall.attachRecord',
                [
                    'CALL_ID' => $callId,
                    'FILENAME' => $fileName,
                    'FILE_CONTENT' => $fileContent,
                    'RECORD_URL' => $recordUrl,
                ]
            )
        );
    }

    /**
     * This method allows to retrieve information about a client from CRM by a telephone number via single request.
     *
     * If CRM has duplicates by phone, method find and return ONLY one of duplicates
     * Method do NOT FIND phones with different phone prefixes +7 or +8 or without it, all phones must by standardised
     *
     * @param string $phoneNumber
     *
     * @return ExternalCallSearchCrmEntitiesResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalCall_searchCrmEntities.php
     */

    public function searchCrmEntities(string $phoneNumber): ExternalCallSearchCrmEntitiesResult
    {
        return new ExternalCallSearchCrmEntitiesResult(
            $this->core->call(
                'telephony.externalCall.searchCrmEntities',
                [
                    'PHONE_NUMBER'=>$phoneNumber,
                ]
            )
        );
    }
}