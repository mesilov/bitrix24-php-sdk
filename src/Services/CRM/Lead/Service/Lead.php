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

namespace Bitrix24\SDK\Services\CRM\Lead\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
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
use Bitrix24\SDK\Services\CRM\Lead\Result\LeadResult;
use Bitrix24\SDK\Services\CRM\Lead\Result\LeadsResult;
use Psr\Log\LoggerInterface;
#[ApiServiceMetadata(new Scope(['crm']))]
class Lead extends AbstractService
{
    public Batch $batch;

    /**
     * Lead constructor.
     *
     * @param Batch           $batch
     * @param CoreInterface   $core
     * @param LoggerInterface $log
     */
    public function __construct(Batch $batch, CoreInterface $core, LoggerInterface $log)
    {
        parent::__construct($core, $log);
        $this->batch = $batch;
    }

    /**
     * add new lead
     *
     * @link https://training.bitrix24.com/rest_help/crm/leads/crm_lead_add.php
     *
     * @param array{
     *   ID?: int,
     *   TITLE?: string,
     *   HONORIFIC?: string,
     *   NAME?: string,
     *   SECOND_NAME?: string,
     *   LAST_NAME?: string,
     *   BIRTHDATE?: string,
     *   COMPANY_TITLE?: string,
     *   SOURCE_ID?: string,
     *   SOURCE_DESCRIPTION?: string,
     *   STATUS_ID?: string,
     *   STATUS_DESCRIPTION?: string,
     *   STATUS_SEMANTIC_ID?: string,
     *   POST?: string,
     *   ADDRESS?: string,
     *   ADDRESS_2?: string,
     *   ADDRESS_CITY?: string,
     *   ADDRESS_POSTAL_CODE?: string,
     *   ADDRESS_REGION?: string,
     *   ADDRESS_PROVINCE?: string,
     *   ADDRESS_COUNTRY?: string,
     *   ADDRESS_COUNTRY_CODE?: string,
     *   ADDRESS_LOC_ADDR_ID?: int,
     *   CURRENCY_ID?: string,
     *   OPPORTUNITY?: string,
     *   IS_MANUAL_OPPORTUNITY?: string,
     *   OPENED?: string,
     *   COMMENTS?: string,
     *   HAS_PHONE?: string,
     *   HAS_EMAIL?: string,
     *   HAS_IMOL?: string,
     *   ASSIGNED_BY_ID?: string,
     *   CREATED_BY_ID?: string,
     *   MODIFY_BY_ID?: string,
     *   MOVED_BY_ID?: string,
     *   DATE_CREATE?: string,
     *   DATE_MODIFY?: string,
     *   MOVED_TIME?: string,
     *   COMPANY_ID?: string,
     *   CONTACT_ID?: string,
     *   CONTACT_IDS?: string,
     *   IS_RETURN_CUSTOMER?: string,
     *   DATE_CLOSED?: string,
     *   ORIGINATOR_ID?: string,
     *   ORIGIN_ID?: string,
     *   UTM_SOURCE?: string,
     *   UTM_MEDIUM?: string,
     *   UTM_CAMPAIGN?: string,
     *   UTM_CONTENT?: string,
     *   UTM_TERM?: string,
     *   PHONE?: string,
     *   EMAIL?: string,
     *   WEB?: string,
     *   IM?: string,
     *   LINK?: string
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
        'crm.lead.add',
        'https://training.bitrix24.com/rest_help/crm/leads/crm_lead_add.php',
        'Method adds new lead'
    )]
    public function add(array $fields, array $params = []): AddedItemResult
    {
        return new AddedItemResult(
            $this->core->call(
                'crm.lead.add',
                [
                    'fields' => $fields,
                    'params' => $params,
                ]
            )
        );
    }

    /**
     * Deletes the specified lead and all the associated objects.
     *
     * @link https://training.bitrix24.com/rest_help/crm/leads/crm_lead_delete.php
     *
     * @param int $id
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.lead.delete',
        'https://training.bitrix24.com/rest_help/crm/leads/crm_lead_delete.php',
        'Deletes the specified lead and all the associated objects.'
    )]
    public function delete(int $id): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.lead.delete',
                [
                    'id' => $id,
                ]
            )
        );
    }

    /**
     * Returns the description of the lead fields, including user fields.
     *
     * @link https://training.bitrix24.com/rest_help/crm/leads/crm_lead_fields.php
     *
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.lead.fields',
        'https://training.bitrix24.com/rest_help/crm/leads/crm_lead_fields.php',
        'Returns the description of the lead fields, including user fields.'
    )]
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.lead.fields'));
    }

    /**
     * Returns a lead by the lead ID.
     *
     * @link https://training.bitrix24.com/rest_help/crm/leads/crm_lead_get.php
     *
     * @param int $id
     *
     * @return LeadResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.lead.get',
        'https://training.bitrix24.com/rest_help/crm/leads/crm_lead_get.php',
        'Returns a lead by the lead ID.'
    )]
    public function get(int $id): LeadResult
    {
        return new LeadResult($this->core->call('crm.lead.get', ['id' => $id]));
    }

    /**
     * Get list of lead items.
     *
     * @link https://training.bitrix24.com/rest_help/crm/leads/crm_lead_list.php
     *
     * @param array   $order     - order of lead items
     * @param array   $filter    - filter array
     * @param array   $select    = ['ID','TITLE','HONORIFIC','NAME','SECOND_NAME','LAST_NAME','BIRTHDATE','COMPANY_TITLE','SOURCE_ID','SOURCE_DESCRIPTION','STATUS_ID','STATUS_DESCRIPTION','STATUS_SEMANTIC_ID','POST','ADDRESS','ADDRESS_2','ADDRESS_CITY','ADDRESS_POSTAL_CODE','ADDRESS_REGION','ADDRESS_PROVINCE','ADDRESS_COUNTRY','ADDRESS_COUNTRY_CODE','ADDRESS_LOC_ADDR_ID','CURRENCY_ID','OPPORTUNITY','IS_MANUAL_OPPORTUNITY','OPENED','COMMENTS','HAS_PHONE','HAS_EMAIL','HAS_IMOL','ASSIGNED_BY_ID','CREATED_BY_ID','MODIFY_BY_ID','MOVED_BY_ID','DATE_CREATE','DATE_MODIFY','MOVED_TIME','COMPANY_ID','CONTACT_ID','CONTACT_IDS','IS_RETURN_CUSTOMER','DATE_CLOSED','ORIGINATOR_ID','ORIGIN_ID','UTM_SOURCE','UTM_MEDIUM','UTM_CAMPAIGN','UTM_CONTENT','UTM_TERM','PHONE','EMAIL','WEB','IM','LINK']
     * @param integer $startItem - entity number to start from (usually returned in 'next' field of previous 'crm.lead.list' API call)
     *
     * @throws BaseException
     * @throws TransportException
     * @return LeadsResult
     */
    #[ApiEndpointMetadata(
        'crm.lead.list',
        'https://training.bitrix24.com/rest_help/crm/leads/crm_lead_list.php',
        'Get list of lead items.'
    )]
    public function list(array $order, array $filter, array $select, int $startItem = 0): LeadsResult
    {
        return new LeadsResult(
            $this->core->call(
                'crm.lead.list',
                [
                    'order'  => $order,
                    'filter' => $filter,
                    'select' => $select,
                    'start'  => $startItem,
                ]
            )
        );
    }

    /**
     * Updates the specified (existing) lead.
     *
     * @link https://training.bitrix24.com/rest_help/crm/leads/crm_lead_update.php
     *
     * @param int $id
     * @param array{
     *   ID?: int,
     *   TITLE?: string,
     *   HONORIFIC?: string,
     *   NAME?: string,
     *   SECOND_NAME?: string,
     *   LAST_NAME?: string,
     *   BIRTHDATE?: string,
     *   COMPANY_TITLE?: string,
     *   SOURCE_ID?: string,
     *   SOURCE_DESCRIPTION?: string,
     *   STATUS_ID?: string,
     *   STATUS_DESCRIPTION?: string,
     *   STATUS_SEMANTIC_ID?: string,
     *   POST?: string,
     *   ADDRESS?: string,
     *   ADDRESS_2?: string,
     *   ADDRESS_CITY?: string,
     *   ADDRESS_POSTAL_CODE?: string,
     *   ADDRESS_REGION?: string,
     *   ADDRESS_PROVINCE?: string,
     *   ADDRESS_COUNTRY?: string,
     *   ADDRESS_COUNTRY_CODE?: string,
     *   ADDRESS_LOC_ADDR_ID?: int,
     *   CURRENCY_ID?: string,
     *   OPPORTUNITY?: string,
     *   IS_MANUAL_OPPORTUNITY?: string,
     *   OPENED?: string,
     *   COMMENTS?: string,
     *   HAS_PHONE?: string,
     *   HAS_EMAIL?: string,
     *   HAS_IMOL?: string,
     *   ASSIGNED_BY_ID?: string,
     *   CREATED_BY_ID?: string,
     *   MODIFY_BY_ID?: string,
     *   MOVED_BY_ID?: string,
     *   DATE_CREATE?: string,
     *   DATE_MODIFY?: string,
     *   MOVED_TIME?: string,
     *   COMPANY_ID?: string,
     *   CONTACT_ID?: string,
     *   CONTACT_IDS?: string,
     *   IS_RETURN_CUSTOMER?: string,
     *   DATE_CLOSED?: string,
     *   ORIGINATOR_ID?: string,
     *   ORIGIN_ID?: string,
     *   UTM_SOURCE?: string,
     *   UTM_MEDIUM?: string,
     *   UTM_CAMPAIGN?: string,
     *   UTM_CONTENT?: string,
     *   UTM_TERM?: string,
     *   PHONE?: string,
     *   EMAIL?: string,
     *   WEB?: string,
     *   IM?: string,
     *   LINK?: string
     *   }        $fields
     *
     * @param array{
     *   REGISTER_SONET_EVENT?: string
     *   }        $params
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.lead.update',
        'https://training.bitrix24.com/rest_help/crm/leads/crm_lead_update.php',
        'Updates the specified (existing) lead.'
    )]
    public function update(int $id, array $fields, array $params = []): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.lead.update',
                [
                    'id'     => $id,
                    'fields' => $fields,
                    'params' => $params,
                ]
            )
        );
    }

    /**
     * Count leads by filter
     *
     * @param array{
     *   ID?: int,
     *   TITLE?: string,
     *   HONORIFIC?: string,
     *   NAME?: string,
     *   SECOND_NAME?: string,
     *   LAST_NAME?: string,
     *   BIRTHDATE?: string,
     *   COMPANY_TITLE?: string,
     *   SOURCE_ID?: string,
     *   SOURCE_DESCRIPTION?: string,
     *   STATUS_ID?: string,
     *   STATUS_DESCRIPTION?: string,
     *   STATUS_SEMANTIC_ID?: string,
     *   POST?: string,
     *   ADDRESS?: string,
     *   ADDRESS_2?: string,
     *   ADDRESS_CITY?: string,
     *   ADDRESS_POSTAL_CODE?: string,
     *   ADDRESS_REGION?: string,
     *   ADDRESS_PROVINCE?: string,
     *   ADDRESS_COUNTRY?: string,
     *   ADDRESS_COUNTRY_CODE?: string,
     *   ADDRESS_LOC_ADDR_ID?: int,
     *   CURRENCY_ID?: string,
     *   OPPORTUNITY?: string,
     *   IS_MANUAL_OPPORTUNITY?: string,
     *   OPENED?: string,
     *   COMMENTS?: string,
     *   HAS_PHONE?: string,
     *   HAS_EMAIL?: string,
     *   HAS_IMOL?: string,
     *   ASSIGNED_BY_ID?: string,
     *   CREATED_BY_ID?: string,
     *   MODIFY_BY_ID?: string,
     *   MOVED_BY_ID?: string,
     *   DATE_CREATE?: string,
     *   DATE_MODIFY?: string,
     *   MOVED_TIME?: string,
     *   COMPANY_ID?: string,
     *   CONTACT_ID?: string,
     *   CONTACT_IDS?: string,
     *   IS_RETURN_CUSTOMER?: string,
     *   DATE_CLOSED?: string,
     *   ORIGINATOR_ID?: string,
     *   ORIGIN_ID?: string,
     *   UTM_SOURCE?: string,
     *   UTM_MEDIUM?: string,
     *   UTM_CAMPAIGN?: string,
     *   UTM_CONTENT?: string,
     *   UTM_TERM?: string,
     *   PHONE?: string,
     *   EMAIL?: string,
     *   WEB?: string,
     *   IM?: string,
     *   LINK?: string
     *   } $filter
     *
     * @return int
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function countByFilter(array $filter = []): int
    {
        return $this->list([], $filter, ['ID'], 1)->getCoreResponse()->getResponseData()->getPagination()->getTotal();
    }
}