<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallRegisterResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalCallShowResult;


class ExternalCall extends  AbstractService{
    /**
     * The method registers a call in Bitrix24
     *
     * @param string $userPhoneInner
     * @param int $userId
     * @param string $userPhoneNumber
     * @param string $callStartDate
     * @param int $crmCreate
     * @param int $crmSource
     * @param string $crmEntityType
     * @param int $crmEntityId
     * @param int $showCardCall
     * @param int $callListId
     * @param string $outsideLineNumber
     * @param int $typeCall
     *
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalCallRegisterResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalcall_register.php
     */

    public function register_call(string $userPhoneInner, int $userId, string $userPhoneNumber, string $callStartDate, int $crmCreate, int $crmSource, string $crmEntityType,int $crmEntityId, int $showCardCall,int $callListId, string $outsideLineNumber, int $typeCall): ExternalCallRegisterResult
    {
     /*  var_dump($this->core->call(
            'telephony.externalcall.register',
            [
                'USER_PHONE_INNER'=>$userPhoneInner,
                'USER_ID'=>$userId,
                'PHONE_NUMBER'=>$userPhoneNumber,
                'CALL_START_DATE'=>$callStartDate,
                'CRM_CREATE'=>$crmCreate,
                'CRM_SOURCE'=>$crmSource,
                'USER_ENTITY_TYPE'=>$crmEntityType,
                'CRM_ENTITY_ID'=>$crmEntityId,
                'SHOW'=>$showCardCall,
                'CALL_LIST_ID'=>$callListId,
                'LINE_NUMBER'=>$outsideLineNumber,
                'TYPE'=>$typeCall,
            ]
        )
            ->getResponseData()->getResult()->getResultData()
        );exit();*/

        return new ExternalCallRegisterResult(
            $this->core->call(
                    'telephony.externalcall.register',
                [
                    'USER_PHONE_INNER'=>$userPhoneInner,
                    'USER_ID'=>$userId,
                    'PHONE_NUMBER'=>$userPhoneNumber,
                    'CALL_START_DATE'=>$callStartDate,
                    'CRM_CREATE'=>$crmCreate,
                    'CRM_SOURCE'=>$crmSource,
                    'USER_ENTITY_TYPE'=>$crmEntityType,
                    'CRM_ENTITY_ID'=>$crmEntityId,
                    'SHOW'=>$showCardCall,
                    'CALL_LIST_ID'=>$callListId,
                    'LINE_NUMBER'=>$outsideLineNumber,
                    'TYPE'=>$typeCall,
                ]
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
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalCallShowResult
     *
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
}