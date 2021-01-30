<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealCategoriesResult;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealCategoryResult;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealCategoryStatusResult;

/**
 * Class DealCategory
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Service
 */
class DealCategory extends AbstractService
{
    /**
     * Creates a new deal category.
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_add.php
     *
     * @param array{
     *   ID?: int,
     *   CREATED_DATE?: string,
     *   NAME?: string,
     *   IS_LOCKED?: string,
     *   SORT?: int,
     *   } $fields
     *
     * @return AddedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function add(array $fields): AddedItemResult
    {
        return new AddedItemResult(
            $this->core->call(
                'crm.dealcategory.add',
                [
                    'fields' => $fields,
                ]
            )
        );
    }

    /**
     * Deletes a deal category.
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_delete.php
     *
     * @param int $categoryId
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function delete(int $categoryId): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.dealcategory.delete',
                [
                    'id' => $categoryId,
                ]
            )
        );
    }

    /**
     * Returns field description for deal categories.
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_fields.php
     *
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.dealcategory.fields'));
    }

    /**
     * The method reads settings for general deal category
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_default_get.php
     * @return DealCategoryResult
     * @throws BaseException
     * @throws TransportException
     */
    public function getDefaultCategorySettings(): DealCategoryResult
    {
        return new DealCategoryResult($this->core->call('crm.dealcategory.default.get'));
    }

    /**
     * The method writes settings for general deal category.
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_default_set.php
     *
     * @param array{
     *      NAME?: string,
     *      } $parameters
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function setDefaultCategorySettings(array $parameters): UpdatedItemResult
    {
        return new UpdatedItemResult($this->core->call('crm.dealcategory.default.set', $parameters));
    }


    /**
     * Returns deal category by the ID
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_get.php
     *
     * @param int $categoryId
     *
     * @return DealCategoryResult
     * @throws BaseException
     * @throws TransportException
     */
    public function get(int $categoryId): DealCategoryResult
    {
        return new DealCategoryResult(
            $this->core->call(
                'crm.dealcategory.get',
                [
                    'id' => $categoryId,
                ]
            )
        );
    }

    /**
     * Returns a list of deal categories by the filter. Is the implementation of list method for deal categories.
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_list.php
     *
     * @param array $order
     * @param array $filter
     * @param array $select
     * @param int   $start
     *
     * @return DealCategoriesResult
     * @throws BaseException
     * @throws TransportException
     */
    public function list(array $order, array $filter, array $select, int $start): DealCategoriesResult
    {
        return new DealCategoriesResult(
            $this->core->call(
                'crm.dealcategory.list',
                [
                    'order'  => $order,
                    'filter' => $filter,
                    'select' => $select,
                    'start'  => $start,
                ]
            )
        );
    }

    /**
     * Returns directory type ID for storage deal categories by the ID.
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_status.php
     *
     * @param int $categoryId
     *
     * @return DealCategoryStatusResult
     * @throws BaseException
     * @throws TransportException
     */
    public function getStatus(int $categoryId): DealCategoryStatusResult
    {
        return new DealCategoryStatusResult(
            $this->core->call(
                'crm.dealcategory.status',
                [
                    'id' => $categoryId,
                ]
            )
        );
    }

    /**
     * Updates an existing category.
     *
     * @link https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_update.php
     *
     * @param int $categoryId
     * @param array{
     *   ID?: int,
     *   CREATED_DATE?: string,
     *   NAME?: string,
     *   IS_LOCKED?: string,
     *   SORT?: int,
     *   } $fields
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function update(int $categoryId, array $fields): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.dealcategory.update',
                [
                    'id'     => $categoryId,
                    'fields' => $fields,
                ]
            )
        );
    }
}