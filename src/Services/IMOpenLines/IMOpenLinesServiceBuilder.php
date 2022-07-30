<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\IMOpenLines;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\IMOpenLines\Service\Network;

class IMOpenLinesServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return \Bitrix24\SDK\Services\IMOpenLines\Service\Network
     */
    public function Network(): Network
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Network($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}