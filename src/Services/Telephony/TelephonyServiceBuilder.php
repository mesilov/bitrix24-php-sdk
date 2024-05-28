<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Telephony;

class TelephonyServiceBuilder extends AbstractServiceBuilder
{
    public function externalCall(): Telephony\ExternalCall\Service\ExternalCall
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Telephony\ExternalCall\Service\ExternalCall(
                new Telephony\ExternalCall\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}