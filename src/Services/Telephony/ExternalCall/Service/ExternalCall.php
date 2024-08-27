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

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\FileNotFoundException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\UserInterfaceDialogCallResult;
use Bitrix24\SDK\Infrastructure\Filesystem\Base64Encoder;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\TelephonyCallStatusCode;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\CallRecordFileUploadedResult;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\CallRecordUploadUrlResult;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\ExternalCallFinishedResult;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\ExternalCallRegisteredResult;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\SearchCrmEntitiesResult;
use Carbon\CarbonImmutable;
use Money\Money;
use Psr\Log\LoggerInterface;

#[ApiServiceMetadata(new Scope(['telephony']))]
class ExternalCall extends AbstractService
{
    public function __construct(
        readonly public Batch          $batch,
        private readonly Base64Encoder $base64Encoder,
        CoreInterface                  $core,
        LoggerInterface                $logger
    )
    {
        parent::__construct($core, $logger);
    }

    /**
     * Get url for upload call record
     *
     * @param non-empty-string $callId
     * @param non-empty-string $callRecordFileName
     * @throws BaseException
     * @throws InvalidArgumentException
     * @throws TransportException
     * @throws FileNotFoundException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalCall_attachRecord.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalCall.attachRecord',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalCall_attachRecord.php',
        'Get url for upload call record'
    )]
    public function getCallRecordUploadUrl(
        string $callId,
        string $callRecordFileName,
    ): CallRecordUploadUrlResult
    {
        return new CallRecordUploadUrlResult($this->core->call('telephony.externalCall.attachRecord', [
            'CALL_ID' => $callId,
            'FILENAME' => pathinfo($callRecordFileName, PATHINFO_BASENAME),
            'FILE_CONTENT' => null
        ]));
    }

    /**
     * This method connects a record to a finished call and to the call Activity.
     *
     * @param non-empty-string $callId
     * @param non-empty-string $callRecordFileName
     * @throws BaseException
     * @throws InvalidArgumentException
     * @throws TransportException
     * @throws FileNotFoundException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalCall_attachRecord.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalCall.attachRecord',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalCall_attachRecord.php',
        'This method connects a record to a finished call and to the call Activity.'
    )]
    public function attachCallRecordInBase64(
        string $callId,
        string $callRecordFileName,
    ): CallRecordFileUploadedResult
    {
        return new CallRecordFileUploadedResult($this->core->call('telephony.externalCall.attachRecord', [
            'CALL_ID' => $callId,
            // we need unique uploaded filename
            'FILENAME' => sprintf('%s-%s', time(), pathinfo($callRecordFileName, PATHINFO_BASENAME)),
            'FILE_CONTENT' => $this->base64Encoder->encodeCallRecord($callRecordFileName)
        ]));
    }

    /**
     * Method registers a call in Bitrix24. For this purpose, it searches an object that corresponds to the number in CRM.
     *
     * If the method finds it, it adds the call, connected to the object found. If the method didn't find it, it can create a lead automatically.
     *
     * First user previously responsible for this customer is assigned as the responsible for a new lead automatically when using telephony.externalCall.register.
     * You subsequently can change such responsible user via telephony.externalcall.finish.
     * Simultaneously with the registration of a call, method optionally can show the user the call ID screen.
     * The user that views the displayed call pane, is identified either by USER_ID or by USER_PHONE_INNER.
     * (That is, fields are marked as required, but actually, only one of two is required).
     *
     * No need to repeatedly call this method for call received at the event OnExternalCallStart.
     * Such calls have been registered already in the system and you need to only call telephony.externalcall.finish when call finishes.
     *
     * Attention! Repeated call telephony.externalcall.register with the same parameters, without closing the previous
     * call by the method telephony.externalcall.finish - fetches the same CALL_ID during 30 minutes.
     *
     * To create a call "activity", it is also necessary to call the telephony.externalcall.finish method
     *
     * @param non-empty-string $userInnerPhoneNumber Internal number of the user. Required.
     * @param non-negative-int $b24UserId User ID. Required.
     * @param non-empty-string $phoneNumber Telephone number. Required
     * @param CarbonImmutable $callStartDate Date/time of the call in the ISO8601 format. Please note, that the date must pass an hour zone, to avoid confusing call time
     * @param CallType $callType Type of call:
     * 1 - outbound
     * 2 - inbound
     * 3 - inbound with forwarding
     * 4 - callback
     * @param bool $isShowCallCard Option to display or not the call ID screen
     * @param bool|null $isCreateCrmEntities Automatic creating of CRM entity associated with a call.
     * If required, creates a lead or deal in CRM, depending on settings and performance CRM mode.
     * Please note, a deal activity is created with any value of this parameter, if possible.
     * @param non-empty-string|null $lineNumber Number of external line, via which the call was made (see. telephony.externalLine.add). Optional.
     * @param non-empty-string|null $sourceId STATUS_ID of the source from the source selection list.
     * You can receive a list of sources by the crm.status.list method with filter by "ENTITY_ID": "SOURCE"
     * @param CrmEntityType|null $crmEntityType Type of CRM object, from the details card of which the call is made - CONTACT | COMPANY | LEAD.
     * @param int|null $crmEntityId CRM object ID, type of which is specified in CRM_ENTITY_TYPE
     * @param int|null $callListId Call dialing list ID, to which the call should be connected.
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_register.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalcall.register',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_register.php',
        'Method registers a call in Bitrix24. For this purpose, it searches an object that corresponds to the number in CRM.'
    )]
    public function register(
        string          $userInnerPhoneNumber,
        int             $b24UserId,
        string          $phoneNumber,
        CarbonImmutable $callStartDate,
        CallType        $callType,
        bool            $isShowCallCard = true,
        ?bool           $isCreateCrmEntities = null,
        ?string         $lineNumber = null,
        ?string         $sourceId = null,
        ?CrmEntityType  $crmEntityType = null,
        ?int            $crmEntityId = null,
        ?int            $callListId = null,
    ): ExternalCallRegisteredResult
    {
        return new ExternalCallRegisteredResult(
            $this->core->call('telephony.externalcall.register',
                [
                    'USER_PHONE_INNER' => $userInnerPhoneNumber,
                    'USER_ID' => $b24UserId,
                    'PHONE_NUMBER' => $phoneNumber,
                    'CALL_START_DATE' => $callStartDate->format(DATE_ATOM),
                    'CRM_CREATE' => $isCreateCrmEntities === true ? 1 : 0,
                    'CRM_SOURCE' => $sourceId,
                    'CRM_ENTITY_TYPE' => $crmEntityType?->value,
                    'CRM_ENTITY_ID' => $crmEntityId,
                    'SHOW' => $isShowCallCard ? 1 : 0,
                    'CALL_LIST_ID' => $callListId,
                    'LINE_NUMBER' => $lineNumber,
                    'TYPE' => $callType->value,
                ])
        );
    }

    /**
     * This method allows to retrieve information about a client from CRM by a telephone number via single request.
     *
     * This method allows to retrieve information about a client from CRM by a telephone number via single request.
     * This information allows to make a decision, to which employee the inbound call shall be forwarded to at the very moment of the call.
     * This method returns a suitable list of CRM objects with sorting by internal priorities.
     * If different employees are responsible for entities, linked with the number (one employee is responsible for a lead,
     * and another employee is responsible for a company), then it is recommended to select the object,
     * which was returned by the method as the first in the list. If integration has its own logic, then a selection is possible,
     * because all the objects are transferred.
     *
     * All information about an employee, responsible for each object is provided right away in the list of CRM objects
     * (so that there is no necessity to retrieve this information via additional REST requests). All contact phone numbers
     * specified for a user are returned: internal telephone number for an employee, work office and etc.
     *
     * An employee workday status is also returned (if work time management feature is enabled in the user's Bitrix24 account).
     * The integration can check, whether an employee is located at the workplace at the moment (or he/she is having a lunchtime break),
     * or it can forward a phone call to a queue, or forward a call to a mobile phone of an employee and etc.
     *
     * It is recommended to call this method prior to calling the telephony.externalcall.register method.
     *
     * @param non-empty-string $phoneNumber
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'telephony.externalCall.searchCrmEntities',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalCall_searchCrmEntities.php',
        'This method allows to retrieve information about a client from CRM by a telephone number via single request.'
    )]
    public function searchCrmEntities(string $phoneNumber): SearchCrmEntitiesResult
    {
        return new SearchCrmEntitiesResult($this->core->call('telephony.externalCall.searchCrmEntities',
            [
                'PHONE_NUMBER' => $phoneNumber
            ]));
    }

    /**
     * Method completes the call, registers it in the statistics and hides the call ID screen from the user.
     *
     * @param non-empty-string $callId
     * @param non-empty-string $userInnerPhoneNumber
     * @param non-negative-int $duration
     * @param non-empty-string|null $failedReason
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_finish.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalcall.finish',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_finish.php',
        'This method allows to retrieve information about a client from CRM by a telephone number via single request.'
    )]
    public function finishForUserPhoneInner(
        string                  $callId,
        string                  $userInnerPhoneNumber,
        int                     $duration,
        Money                   $money,
        TelephonyCallStatusCode $telephonyCallStatusCode,
        bool                    $isAddCallToChat = false,
        ?string                 $failedReason = null,
        ?int                    $userVote = null,
    ): ExternalCallFinishedResult
    {
        return new ExternalCallFinishedResult($this->core->call('telephony.externalcall.finish',
            [
                'CALL_ID' => $callId,
                'USER_ID' => $userInnerPhoneNumber,
                'DURATION' => $duration,
                'COST' => $this->decimalMoneyFormatter->format($money),
                'COST_CURRENCY' => $money->getCurrency()->getCode(),
                'STATUS_CODE' => $telephonyCallStatusCode->value,
                'FAILED_REASON' => $failedReason,
                'VOTE' => $userVote,
                'ADD_TO_CHAT' => $isAddCallToChat ? 1 : 0
            ]));
    }

    /**
     * Method completes the call, registers it in the statistics and hides the call ID screen from the user.
     *
     * @param non-empty-string $callId
     * @param positive-int $b24UserId
     * @param non-negative-int $duration
     * @param non-empty-string|null $failedReason
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_finish.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalcall.finish',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_finish.php',
        'This method allows to retrieve information about a client from CRM by a telephone number via single request.'
    )]
    public function finishForUserId(
        string                  $callId,
        int                     $b24UserId,
        int                     $duration,
        Money                   $money,
        TelephonyCallStatusCode $telephonyCallStatusCode,
        bool                    $isAddCallToChat = false,
        ?string                 $failedReason = null,
        ?int                    $userVote = null,
    ): ExternalCallFinishedResult
    {
        return new ExternalCallFinishedResult($this->core->call('telephony.externalcall.finish',
            [
                'CALL_ID' => $callId,
                'USER_ID' => $b24UserId,
                'DURATION' => $duration,
                'COST' => $this->decimalMoneyFormatter->format($money),
                'COST_CURRENCY' => $money->getCurrency()->getCode(),
                'STATUS_CODE' => $telephonyCallStatusCode->value,
                'FAILED_REASON' => $failedReason,
                'VOTE' => $userVote,
                'ADD_TO_CHAT' => $isAddCallToChat ? 1 : 0
            ]));
    }

    /**
     *  The method displays a call ID screen to the user.
     *
     * @param non-empty-string $callId
     * @param array<int> $b24UserId
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_show.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalcall.show',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_show.php',
        'The method displays a call ID screen to the user.'
    )]
    public function show(string $callId, array $b24UserId): UserInterfaceDialogCallResult
    {
        return new UserInterfaceDialogCallResult($this->core->call('telephony.externalcall.show',
            [
                'CALL_ID' => $callId,
                'USER_ID' => $b24UserId
            ]));
    }

    /**
     *  This method hides call information window.
     *
     * @param non-empty-string $callId
     * @param array<int> $b24UserId
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_hide.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalcall.hide',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_hide.php',
        ' This method hides call information window.'
    )]
    public function hide(string $callId, array $b24UserId): UserInterfaceDialogCallResult
    {
        return new UserInterfaceDialogCallResult($this->core->call('telephony.externalcall.hide',
            [
                'CALL_ID' => $callId,
                'USER_ID' => $b24UserId
            ]));
    }
}