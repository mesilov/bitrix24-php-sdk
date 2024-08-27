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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\TTS\Voices\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;

use Bitrix24\SDK\Services\Telephony\Voximplant\TTS\Voices\Result\VoximplantVoicesResult;
use Psr\Log\LoggerInterface;

#[ApiServiceMetadata(new Scope(['telephony']))]
class Voices extends AbstractService
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
     * Returns an array of available voices for generation of speech in the format of voice ID => voice name.
     *
     * This method does not have limitation of access permissions .
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_tts_voices.get.php
     */
    #[ApiEndpointMetadata(
        'voximplant.tts.voices.get',
        'https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_tts_voices.get.php',
        'Returns an array of available voices for generation of speech in the format of voice ID => voice name.'
    )]
    public function get(): VoximplantVoicesResult
    {
        return new VoximplantVoicesResult($this->core->call('voximplant.tts.voices.get'));
    }
}