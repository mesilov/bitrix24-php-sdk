<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Placement;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Placement\Service\Placement;

class PlacementServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return Placement
     */
    public function placement(): Placement
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Placement($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}