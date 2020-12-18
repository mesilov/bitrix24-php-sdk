<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\CRM\Contacts\Service\Contacts;
use Bitrix24\SDK\Services\CRM\Deals\Service\DealCategory;
use Bitrix24\SDK\Services\CRM\Deals\Service\DealCategoryStages;
use Bitrix24\SDK\Services\CRM\Deals\Service\DealProductRows;
use Bitrix24\SDK\Services\CRM\Deals\Service\Deals;
use Bitrix24\SDK\Services\CRM\Products\Service\Products;

/**
 * Class CRMServiceBuilder
 *
 * @package Bitrix24\SDK\Services\CRM
 */
class CRMServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return DealCategory
     */
    public function dealCategory(): DealCategory
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new DealCategory($this->core, $this->batch, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Deals
     */
    public function deals(): Deals
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Deals($this->core, $this->batch, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Products
     */
    public function products(): Products
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Products($this->core, $this->batch, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Contacts
     */
    public function contacts(): Contacts
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Contacts($this->core, $this->batch, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return DealProductRows
     */
    public function dealProductRows(): DealProductRows
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new DealProductRows($this->core, $this->batch, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return DealCategoryStages
     */
    public function dealCategoryStages(): DealCategoryStages
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new DealCategoryStages($this->core, $this->batch, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}