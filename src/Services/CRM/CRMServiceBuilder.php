<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM;

use Bitrix24\SDK\Services\AbstractServiceBuilder;

class CRMServiceBuilder extends AbstractServiceBuilder
{
    public function settings(): Settings\Service\Settings
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Settings\Service\Settings($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function dealContact(): Deal\Service\DealContact
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealContact($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function dealCategory(): Deal\Service\DealCategory
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealCategory($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function deal(): Deal\Service\Deal
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\Deal(
                new Deal\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function dealUserfield(): Deal\Service\DealUserfield
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealUserfield(
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function contact(): Contact\Service\Contact
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Contact\Service\Contact(
                new Contact\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function contactUserfield(): Contact\Service\ContactUserfield
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Contact\Service\ContactUserfield(
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Deal\Service\DealProductRows
     */
    public function dealProductRows(): Deal\Service\DealProductRows
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealProductRows($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function dealCategoryStage(): Deal\Service\DealCategoryStage
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealCategoryStage($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function product(): Product\Service\Product
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Product\Service\Product(
                new Product\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function userfield(): Userfield\Service\Userfield
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Userfield\Service\Userfield(
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function lead(): Lead\Service\Lead
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Lead\Service\Lead(
                new Lead\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function activity(): Activity\Service\Activity
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Activity\Service\Activity(
                new Activity\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function activityFetcher(): Activity\ActivityFetcherBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Activity\ActivityFetcherBuilder(
                $this->core,
                $this->batch,
                $this->bulkItemsReader,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function item(): Item\Service\Item
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Item\Service\Item(
                new Item\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function duplicate(): Duplicates\Service\Duplicate
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Duplicates\Service\Duplicate(
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}