<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\ExternalLine\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
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
use Bitrix24\SDK\Services\Telephony\ExternalLine\Result\ExternalLineAddedResult;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Service\Batch;
use Carbon\CarbonImmutable;
use Money\Money;
use Psr\Log\LoggerInterface;

class ExternalLine extends AbstractService
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
     * Method adds an external line
     *
     * @param non-empty-string $lineNumber Number of the external line (For example: 8-9938-832799312)
     * @param bool $isAutoCreateCrmEntities This parameter is responsible for creating CRM entities (deal or lead, depending on the CRM mode)
     * for outbound calls from Bitrix24 interface (for example, dialer in chat panel). Default value is true
     * @param non-empty-string|null $lineName Name of the external line. Optional.
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_add.php
     */
    public function add(string $lineNumber, bool $isAutoCreateCrmEntities = true, ?string $lineName = null): ExternalLineAddedResult
    {
        return new ExternalLineAddedResult($this->core->call('telephony.externalLine.add', [
            'NUMBER' => $lineNumber,
            'NAME' => $lineName,
            'CRM_AUTO_CREATE' => $isAutoCreateCrmEntities ? 'Y' : 'N'
        ]));
    }
}