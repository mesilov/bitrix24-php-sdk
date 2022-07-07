<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Telephony\Service\ExternalLine;
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;


class TelephonyServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return ExternalLine
     */
    public function externalline(): ExternalLine
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new ExternalLine($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return ExternalCall
     */
    public function externalCall(): ExternalCall
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new ExternalCall($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

}