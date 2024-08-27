<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Services\Catalog\CatalogServiceBuilder;
use Bitrix24\SDK\Services\CRM\CRMServiceBuilder;
use Bitrix24\SDK\Services\IM\IMServiceBuilder;
use Bitrix24\SDK\Services\IMOpenLines\IMOpenLinesServiceBuilder;
use Bitrix24\SDK\Services\Main\MainServiceBuilder;
use Bitrix24\SDK\Services\Telephony\TelephonyServiceBuilder;
use Bitrix24\SDK\Services\User\UserServiceBuilder;
use Bitrix24\SDK\Services\UserConsent\UserConsentServiceBuilder;
use Bitrix24\SDK\Services\Placement\PlacementServiceBuilder;
use Bitrix24\SDK\Services\Workflows\WorkflowsServiceBuilder;

class ServiceBuilder extends AbstractServiceBuilder
{
    public function getCRMScope(): CRMServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new CRMServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function getIMScope(): IMServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new IMServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function getIMOpenLinesScope(): IMOpenLinesServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new IMOpenLinesServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
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

    public function getUserConsentScope(): UserConsentServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new UserConsentServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function getUserScope(): UserServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new UserServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return PlacementServiceBuilder
     */
    public function getPlacementScope(): PlacementServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new PlacementServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function getCatalogScope(): CatalogServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new CatalogServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function getBizProcScope(): WorkflowsServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new WorkflowsServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function getTelephonyScope(): TelephonyServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new TelephonyServiceBuilder($this->core, $this->batch, $this->bulkItemsReader, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}