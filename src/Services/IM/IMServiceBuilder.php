<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\IM;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\IM\Notify\Service\Notify;

class IMServiceBuilder extends AbstractServiceBuilder
{
    public function notify(): Notify
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Notify($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}