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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipConnectorStatusResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipLineAddedResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipLinesResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipLineStatusResult;
use Psr\Log\LoggerInterface;
#[ApiServiceMetadata(new Scope(['telephony']))]
class Sip extends AbstractService
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
     * Returns the current status of the SIP Connector.
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_connector_status.php
     */
    #[ApiEndpointMetadata(
        'voximplant.sip.connector.status',
        'https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_connector_status.php',
        'Returns the current status of the SIP Connector.'
    )]
    public function getConnectorStatus(): SipConnectorStatusResult
    {
        return new SipConnectorStatusResult($this->core->call('voximplant.sip.connector.status'));
    }

    /**
     * Creates a new SIP line linked to the application. Once created, this line becomes an outbound line by default.
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     *
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_add.php
     */
    #[ApiEndpointMetadata(
        'voximplant.sip.add',
        'https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_add.php',
        'Сreates a new SIP line linked to the application. Once created, this line becomes an outbound line by default.'
    )]
    public function add(
        PbxType $pbxType,
        string  $title,
        string  $serverUrl,
        string  $login,
        string  $password
    ): SipLineAddedResult
    {
        return new SipLineAddedResult($this->core->call('voximplant.sip.add', [
            'TYPE' => $pbxType->value,
            'TITLE' => $title,
            'SERVER' => $serverUrl,
            'LOGIN' => $login,
            'PASSWORD' => $password
        ]));
    }

    /**
     * Deletes the current SIP line (created by the application).
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     * @param int $sipConfigId SIP line setup identifier.
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_delete.php
     */
    #[ApiEndpointMetadata(
        'voximplant.sip.delete',
        'https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_delete.php',
        'Deletes the current SIP line (created by the application).'
    )]
    public function delete(int $sipConfigId): DeletedItemResult
    {
        return new DeletedItemResult($this->core->call('voximplant.sip.delete', [
            'CONFIG_ID' => $sipConfigId
        ]));
    }

    /**
     * Returns the list of all SIP lines created by the application. It is a list method.
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_get.php
     */
    #[ApiEndpointMetadata(
        'voximplant.sip.get',
        'https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_get.php',
        'Returns the list of all SIP lines created by the application. It is a list method.'
    )]
    public function get(): SipLinesResult
    {
        return new SipLinesResult($this->core->call('voximplant.sip.get'));
    }

    /**
     * Returns the current status of the SIP registration (for cloud hosted PBX only).
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     *
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_status.php
     * @param int $sipRegistrationId SIP registration identifier.
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'voximplant.sip.status',
        'https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_status.php',
        'Returns the current status of the SIP registration (for cloud hosted PBX only).'
    )]
    public function status(int $sipRegistrationId): SipLineStatusResult
    {
        return new SipLineStatusResult($this->core->call('voximplant.sip.status', [
            'REG_ID' => $sipRegistrationId
        ]));
    }

    /**
     * Updates the existing SIP line (created by the application).
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     *
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_update.php
     * @throws InvalidArgumentException
     */
    #[ApiEndpointMetadata(
        'voximplant.sip.update',
        'https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_sip_update.php',
        'Updates the existing SIP line (created by the application).'
    )]
    public function update(int     $sipConfigId,
                           PbxType $pbxType,
                           ?string $title = null,
                           ?string $serverUrl = null,
                           ?string $login = null,
                           ?string $password = null): UpdatedItemResult
    {
        $fieldsForUpdate = [];
        if ($title !== null) {
            $fieldsForUpdate['TITLE'] = $title;
        }

        if ($serverUrl !== null) {
            $fieldsForUpdate['SERVER'] = $serverUrl;
        }

        if ($login !== null) {
            $fieldsForUpdate['LOGIN'] = $login;
        }

        if ($password !== null) {
            $fieldsForUpdate['PASSWORD'] = $password;
        }

        if ($fieldsForUpdate === []) {
            throw new InvalidArgumentException('you must set minimum one field: title, server, login, password');
        }

        return new UpdatedItemResult($this->core->call('voximplant.sip.update',
            array_merge([
                'CONFIG_ID' => $sipConfigId,
                'TYPE' => $pbxType->name
            ],
                $fieldsForUpdate)
        ));
    }
}