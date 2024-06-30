<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\InfoCall\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;

use Bitrix24\SDK\Services\Telephony\Voximplant\InfoCall\Result\VoximplantInfoCallResult;
use Psr\Log\LoggerInterface;

class InfoCall extends AbstractService
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
     * method performs the call to the specified number with automatic voiceover of specified text
     *
     * method available the user with granted access permission for the Outbound call - Action - Any.
     *
     * @param non-empty-string $lineId
     * @param non-empty-string $toNumber
     * @param non-empty-string $text
     * @param non-empty-string|null $voiceCode
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_infocall_startwithtext.php
     */
    public function startWithText(string $lineId, string $toNumber, string $text, ?string $voiceCode = null): VoximplantInfoCallResult
    {
        return new VoximplantInfoCallResult($this->core->call('voximplant.infocall.startwithtext', [
            'FROM_LINE' => $lineId,
            'TO_NUMBER' => $toNumber,
            'TEXT_TO_PRONOUNCE' => $text,
            'VOICE' => $voiceCode
        ]));
    }

    public function startWithSound(string $lineId, string $toNumber, string $recordUrl): VoximplantInfoCallResult
    {
        return new VoximplantInfoCallResult($this->core->call('voximplant.infocall.startwithsound', [
            'FROM_LINE' => $lineId,
            'TO_NUMBER' => $toNumber,
            'URL' => $recordUrl
        ]));
    }
}