<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Placement;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Placement\Service\Placement;
use Bitrix24\SDK\Services\Placement\Service\UserFieldType;

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

    /**
     * @return \Bitrix24\SDK\Services\Placement\Service\UserFieldType
     */
    public function userfieldtype(): UserFieldType
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new UserFieldType($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}