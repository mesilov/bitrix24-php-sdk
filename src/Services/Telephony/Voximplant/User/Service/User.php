<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\User\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\EmptyResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Core\Result\UserInterfaceDialogCallResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Result\ExternalLineAddedResult;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Result\ExternalLinesResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipLineAddedResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipLinesResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipLineStatusItemResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipLineStatusResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\User\Result\VoximplantUserSettingsResult;
use Psr\Log\LoggerInterface;

class User extends AbstractService
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
     * This method disables an indicator of SIP-phone availability. Method checks the availability of the access permissions to modify users.
     *
     * This method is accessible to the user with access permissionsgranted for User Settings - Action.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_user_deactivatePhone.php
     */
    public function deactivatePhone(int $userId): UserInterfaceDialogCallResult
    {
        return new UserInterfaceDialogCallResult($this->core->call('voximplant.user.deactivatePhone', [
            'USER_ID' => $userId
        ]));
    }

    /**
     * This method raises the event of SIP-phone availability for an employee. Method checks the availability of the access permissions to modify users.
     *
     * This method is accessible to the user with access permissionsgranted for User Settings - Action.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_user_activatePhone.php
     */
    public function activatePhone(int $userId): UserInterfaceDialogCallResult
    {
        return new UserInterfaceDialogCallResult($this->core->call('voximplant.user.activatePhone', [
            'USER_ID' => $userId
        ]));
    }

    /**
     * This method returns user settings.
     *
     * Method checks the availability of the access permission rights to modify the user and requests the confirmation of administrator prior to completion.
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_user_get.php
     */
    public function get(array $userIds): VoximplantUserSettingsResult
    {
        return new VoximplantUserSettingsResult($this->core->call('voximplant.user.get',
            [
                'USER_ID' => $userIds
            ]
        ));
    }
}