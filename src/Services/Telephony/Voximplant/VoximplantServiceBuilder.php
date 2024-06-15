<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant;

use Bitrix24\SDK\Infrastructure\Filesystem\Base64Encoder;
use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Telephony;
use Symfony\Component\Filesystem\Filesystem;

class VoximplantServiceBuilder extends AbstractServiceBuilder
{
    public function sip(): Telephony\Voximplant\Sip\Service\Sip
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Telephony\Voximplant\Sip\Service\Sip(
                new Telephony\Voximplant\Sip\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}