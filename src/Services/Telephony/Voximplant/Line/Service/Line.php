<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Line\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\UserInterfaceDialogCallResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Voximplant\Line\Result\VoximplantLineIdResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Line\Result\VoximplantLinesResult;
use Psr\Log\LoggerInterface;

class Line extends AbstractService
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
     * Sets the selected SIP line as an outgoing line by default.
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_line_outgoing_sip_set.php
     */
    public function outgoingSipSet(int $sipLineId): UserInterfaceDialogCallResult
    {
        return new UserInterfaceDialogCallResult($this->core->call('voximplant.line.outgoing.sip.set', [
            'CONFIG_ID' => $sipLineId
        ]));
    }

    /**
     * Returns list of all of the available outgoing lines.
     *
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_line_get.php
     */
    public function get(): VoximplantLinesResult
    {
        return new VoximplantLinesResult($this->core->call('voximplant.line.get'));
    }

    /**
     * Returns the currently selected line as an outgoing line by default.
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     *
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_line_outgoing_get.php
     */
    public function outgoingGet(): VoximplantLineIdResult
    {
        return new VoximplantLineIdResult($this->core->call('voximplant.line.outgoing.get'));
    }

    /**
     * Sets the selected line as an outgoing line by default.
     *
     * This method is available to the user with granted access permissions for Manage numbers - Edit - Any.
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_line_outgoing_set.php
     * @param string $lineId Line identifier obtained from the method voximplant.line.get or voximplant.line.outgoing.get.
     * @throws BaseException
     * @throws TransportException
     */
    public function outgoingSet(string $lineId): UserInterfaceDialogCallResult
    {
        return new UserInterfaceDialogCallResult($this->core->call('voximplant.line.outgoing.set', [
            'LINE_ID' => $lineId
        ]));
    }
}