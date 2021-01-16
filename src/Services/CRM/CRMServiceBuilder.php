<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\CRM\Contact;
use Bitrix24\SDK\Services\CRM\Deal;
use Bitrix24\SDK\Services\CRM\Products;
use Bitrix24\SDK\Services\CRM\Settings;


/**
 * Class CRMServiceBuilder
 *
 * @package Bitrix24\SDK\Services\CRM
 */
class CRMServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return Settings\Service\Settings
     */
    public function settings(): Settings\Service\Settings
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Settings\Service\Settings($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Deal\Service\DealContact
     */
    public function dealContact(): Deal\Service\DealContact
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealContact($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Deal\Service\DealCategory
     */
    public function dealCategory(): Deal\Service\DealCategory
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealCategory($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Deal\Service\Deal
     */
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

    /**
     * @return Deal\Service\Products
     */
    public function products(): Deal\Service\Products
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\Products($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Contact\Service\Contact
     */
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

    /**
     * @return Deal\Service\DealProductRows
     */
    public function dealProductRows(): Deal\Service\DealProductRows
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealProductRows($this->core, $this->batch, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Deal\Service\DealCategoryStages
     */
    public function dealCategoryStages(): Deal\Service\DealCategoryStages
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deal\Service\DealCategoryStages($this->core, $this->batch, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}