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

namespace Bitrix24\SDK\Services\CRM\Deal\Service;

use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealResult;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealsResult;
use Psr\Log\LoggerInterface;
use Bitrix24\SDK\Attributes\ApiEndpointMetadata;

#[ApiServiceMetadata(new Scope(['crm']))]
class Deal extends AbstractService
{
    public Batch $batch;

    /**
     * Deal constructor.
     *
     * @param Batch $batch
     * @param CoreInterface $core
     * @param LoggerInterface $log
     */
    public function __construct(Batch $batch, CoreInterface $core, LoggerInterface $log)
    {
        parent::__construct($core, $log);
        $this->batch = $batch;
    }

    /**
     * add new deal
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_add.php
     *
     * @param array{
     *   ID?: int,
     *   TITLE?: string,
     *   TYPE_ID?: string,
     *   CATEGORY_ID?: string,
     *   STAGE_ID?: string,
     *   STAGE_SEMANTIC_ID?: string,
     *   IS_NEW?: string,
     *   IS_RECURRING?: string,
     *   PROBABILITY?: string,
     *   CURRENCY_ID?: string,
     *   OPPORTUNITY?: string,
     *   IS_MANUAL_OPPORTUNITY?: string,
     *   TAX_VALUE?: string,
     *   LEAD_ID?: string,
     *   COMPANY_ID?: string,
     *   CONTACT_ID?: string,
     *   QUOTE_ID?: string,
     *   BEGINDATE?: string,
     *   CLOSEDATE?: string,
     *   OPENED?: string,
     *   CLOSED?: string,
     *   COMMENTS?: string,
     *   ADDITIONAL_INFO?: string,
     *   LOCATION_ID?: string,
     *   IS_RETURN_CUSTOMER?: string,
     *   IS_REPEATED_APPROACH?: string,
     *   SOURCE_ID?: string,
     *   SOURCE_DESCRIPTION?: string,
     *   ORIGINATOR_ID?: string,
     *   ORIGIN_ID?: string,
     *   UTM_SOURCE?: string,
     *   UTM_MEDIUM?: string,
     *   UTM_CAMPAIGN?: string,
     *   UTM_CONTENT?: string,
     *   UTM_TERM?: string
     *   } $fields
     *
     * @param array{
     *   REGISTER_SONET_EVENT?: string
     *   } $params
     *
     * @return AddedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.add',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_add.php',
        'Add new deal'
    )]
    public function add(array $fields, array $params = []): AddedItemResult
    {
        return new AddedItemResult(
            $this->core->call(
                'crm.deal.add',
                [
                    'fields' => $fields,
                    'params' => $params,
                ]
            )
        );
    }

    /**
     * Deletes the specified deal and all the associated objects.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_delete.php
     *
     * @param int $id
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.delete',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_delete.php',
        'Delete deal'
    )]
    public function delete(int $id): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.deal.delete',
                [
                    'id' => $id,
                ]
            )
        );
    }

    /**
     * Returns the description of the deal fields, including user fields.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_fields.php
     *
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.fields',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_fields.php',
        'Get fields of deal'
    )]
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.deal.fields'));
    }

    /**
     * Returns a deal by the deal ID.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_get.php
     *
     * @param int $id
     *
     * @return DealResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.fields',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_get.php',
        'Get deal by id'
    )]
    public function get(int $id): DealResult
    {
        return new DealResult($this->core->call('crm.deal.get', ['id' => $id]));
    }

    /**
     * Get list of deal items.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_list.php
     *
     * @param array $order - order of deal items
     * @param array $filter - filter array
     * @param array $select = ['ID','TITLE','TYPE_ID','CATEGORY_ID','STAGE_ID','STAGE_SEMANTIC_ID','IS_NEW','IS_RECURRING','PROBABILITY', 'CURRENCY_ID', 'OPPORTUNITY','IS_MANUAL_OPPORTUNITY','TAX_VALUE','LEAD_ID','COMPANY_ID','CONTACT_ID','QUOTE_ID','BEGINDATE','CLOSEDATE','OPENED','CLOSED','COMMENTS','ADDITIONAL_INFO','LOCATION_ID','IS_RETURN_CUSTOMER','IS_REPEATED_APPROACH','SOURCE_ID','SOURCE_DESCRIPTION','ORIGINATOR_ID','ORIGIN_ID','UTM_SOURCE','UTM_MEDIUM','UTM_CAMPAIGN','UTM_CONTENT','UTM_TERM']
     * @param integer $startItem - entity number to start from (usually returned in 'next' field of previous 'crm.deal.list' API call)
     *
     * @throws BaseException
     * @throws TransportException
     * @return DealsResult
     */
    #[ApiEndpointMetadata(
        'crm.deal.list',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_list.php',
        'Get deal list by filter'
    )]
    public function list(array $order, array $filter, array $select, int $startItem = 0): DealsResult
    {
        return new DealsResult(
            $this->core->call(
                'crm.deal.list',
                [
                    'order' => $order,
                    'filter' => $filter,
                    'select' => $select,
                    'start' => $startItem,
                ]
            )
        );
    }

    /**
     * Updates the specified (existing) deal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_update.php
     *
     * @param int $id
     * @param array{
     *   ID?: int,
     *   TITLE?: string,
     *   TYPE_ID?: string,
     *   CATEGORY_ID?: string,
     *   STAGE_ID?: string,
     *   STAGE_SEMANTIC_ID?: string,
     *   IS_NEW?: string,
     *   IS_RECURRING?: string,
     *   PROBABILITY?: string,
     *   CURRENCY_ID?: string,
     *   OPPORTUNITY?: string,
     *   IS_MANUAL_OPPORTUNITY?: string,
     *   TAX_VALUE?: string,
     *   LEAD_ID?: string,
     *   COMPANY_ID?: string,
     *   CONTACT_ID?: string,
     *   QUOTE_ID?: string,
     *   BEGINDATE?: string,
     *   CLOSEDATE?: string,
     *   OPENED?: string,
     *   CLOSED?: string,
     *   COMMENTS?: string,
     *   ADDITIONAL_INFO?: string,
     *   LOCATION_ID?: string,
     *   IS_RETURN_CUSTOMER?: string,
     *   IS_REPEATED_APPROACH?: string,
     *   SOURCE_ID?: string,
     *   SOURCE_DESCRIPTION?: string,
     *   ORIGINATOR_ID?: string,
     *   ORIGIN_ID?: string,
     *   UTM_SOURCE?: string,
     *   UTM_MEDIUM?: string,
     *   UTM_CAMPAIGN?: string,
     *   UTM_CONTENT?: string,
     *   UTM_TERM?: string
     *   } $fields
     *
     * @param array{
     *   REGISTER_SONET_EVENT?: string
     *   } $params
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.update',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_update.php',
        'Update deal list by filter'
    )]
    public function update(int $id, array $fields, array $params = []): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.deal.update',
                [
                    'id' => $id,
                    'fields' => $fields,
                    'params' => $params,
                ]
            )
        );
    }

    /**
     * Count deals by filter
     *
     * @param array{
     *   ID?: int,
     *   TITLE?: string,
     *   TYPE_ID?: string,
     *   CATEGORY_ID?: string,
     *   STAGE_ID?: string,
     *   STAGE_SEMANTIC_ID?: string,
     *   IS_NEW?: string,
     *   IS_RECURRING?: string,
     *   PROBABILITY?: string,
     *   CURRENCY_ID?: string,
     *   OPPORTUNITY?: string,
     *   IS_MANUAL_OPPORTUNITY?: string,
     *   TAX_VALUE?: string,
     *   LEAD_ID?: string,
     *   COMPANY_ID?: string,
     *   CONTACT_ID?: string,
     *   QUOTE_ID?: string,
     *   BEGINDATE?: string,
     *   CLOSEDATE?: string,
     *   OPENED?: string,
     *   CLOSED?: string,
     *   COMMENTS?: string,
     *   ADDITIONAL_INFO?: string,
     *   LOCATION_ID?: string,
     *   IS_RETURN_CUSTOMER?: string,
     *   IS_REPEATED_APPROACH?: string,
     *   SOURCE_ID?: string,
     *   SOURCE_DESCRIPTION?: string,
     *   ORIGINATOR_ID?: string,
     *   ORIGIN_ID?: string,
     *   UTM_SOURCE?: string,
     *   UTM_MEDIUM?: string,
     *   UTM_CAMPAIGN?: string,
     *   UTM_CONTENT?: string,
     *   UTM_TERM?: string
     *   } $filter
     *
     * @return int
     * @throws BaseException
     * @throws TransportException
     */
    public function countByFilter(array $filter = []): int
    {
        return $this->list([], $filter, ['ID'], 1)->getCoreResponse()->getResponseData()->getPagination()->getTotal();
    }
}