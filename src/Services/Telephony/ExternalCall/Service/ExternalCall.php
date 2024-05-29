<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\ExternalCall\Result\ExternalCallRegisteredResult;
use Carbon\CarbonImmutable;
use Psr\Log\LoggerInterface;

class ExternalCall extends AbstractService
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
     * @param string $userInnerPhoneNumber Internal number of the user. Required.
     * @param int $b24UserId User ID. Required.
     * @param string $phoneNumber Telephone number. Required
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
     * @param string|null $lineNumber Number of external line, via which the call was made (see. telephony.externalLine.add). Optional.
     * @param string|null $sourceId STATUS_ID of the source from the source selection list.
     * You can receive a list of sources by the crm.status.list method with filter by "ENTITY_ID": "SOURCE"
     * @param CrmEntityType|null $crmEntityType Type of CRM object, from the details card of which the call is made - CONTACT | COMPANY | LEAD.
     * @param int|null $crmEntityId CRM object ID, type of which is specified in CRM_ENTITY_TYPE
     * @param int|null $callListId Call dialing list ID, to which the call should be connected.
     * @return ExternalCallRegisteredResult
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_register.php
     */
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
                    'CRM_CREATE' => $isCreateCrmEntities ? 1 : 0,
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

}