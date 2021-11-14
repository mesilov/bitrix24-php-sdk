<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\IM;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\IM\Service\IM;

/**
 * Class IMServiceBuilder
 *
 * @package Bitrix24\SDK\Services\IM
 */
class IMServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return IM
     */
    public function IM(): IM
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new IM($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}