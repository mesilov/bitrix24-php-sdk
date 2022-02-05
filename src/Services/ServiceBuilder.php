<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Services\CRM\CRMServiceBuilder;
use Bitrix24\SDK\Services\IM\IMServiceBuilder;
use Bitrix24\SDK\Services\Main\MainServiceBuilder;

/**
 * Class ServiceBuilder
 *
 * @package Bitrix24\SDK\Services
 */
class ServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return CRMServiceBuilder
     */
    public function getCRMScope(): CRMServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new CRMServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return IMServiceBuilder
     */
    public function getIMScope(): IMServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new IMServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return MainServiceBuilder
     */
    public function getMainScope(): MainServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new MainServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}