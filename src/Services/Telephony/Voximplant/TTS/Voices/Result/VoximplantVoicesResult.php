<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\TTS\Voices\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class VoximplantVoicesResult extends AbstractResult
{
    /**
     * @return VoximplantVoiceItemResult[]
     * @throws BaseException
     */
    public function getVoices(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $code => $voice) {
            $res[] = new VoximplantVoiceItemResult([
                'CODE' => $code,
                'NAME' => $voice
            ]);
        }

        return $res;
    }
}