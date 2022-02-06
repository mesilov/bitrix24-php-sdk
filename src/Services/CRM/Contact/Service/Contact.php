<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Contact\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Contact\Result\ContactResult;
use Bitrix24\SDK\Services\CRM\Contact\Result\ContactsResult;
use Psr\Log\LoggerInterface;

/**
 * Class Contact
 *
 * @package Bitrix24\SDK\Services\CRM\Contact\Service
 */
class Contact extends AbstractService
{
    public Batch $batch;

    /**
     * Contact constructor.
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
     * Creates and adds a new contact.
     *
     * @link https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_add.php
     *
     * @param array{
     *   ID?: int,
     *   HONORIFIC?: string,
     *   NAME?: string,
     *   SECOND_NAME?: string,
     *   LAST_NAME?: string,
     *   PHOTO?: string,
     *   BIRTHDATE?: string,
     *   TYPE_ID?: string,
     *   SOURCE_ID?: string,
     *   SOURCE_DESCRIPTION?: string,
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
     *   COMMENTS?: string,
     *   OPENED?: string,
     *   EXPORT?: string,
     *   HAS_PHONE?: string,
     *   HAS_EMAIL?: string,
     *   HAS_IMOL?: string,
     *   ASSIGNED_BY_ID?: string,
     *   CREATED_BY_ID?: string,
     *   MODIFY_BY_ID?: string,
     *   DATE_CREATE?: string,
     *   DATE_MODIFY?: string,
     *   COMPANY_ID?: string,
     *   COMPANY_IDS?: string,
     *   LEAD_ID?: string,
     *   ORIGINATOR_ID?: string,
     *   ORIGIN_ID?: string,
     *   ORIGIN_VERSION?: string,
     *   FACE_ID?: int,
     *   UTM_SOURCE?: string,
     *   UTM_MEDIUM?: string,
     *   UTM_CAMPAIGN?: string,
     *   UTM_CONTENT?: string,
     *   UTM_TERM?: string,
     *   PHONE?: string,
     *   EMAIL?: string,
     *   WEB?: string,
     *   IM?: string,
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
    public function add(array $fields, array $params = ['REGISTER_SONET_EVENT' => 'N']): AddedItemResult
    {
        return new AddedItemResult(
            $result = $this->core->call(
                'crm.contact.add',
                [
                    'fields' => $fields,
                    'params' => $params,
                ]
            )
        );
    }

    /**
     * Deletes the specified contact and all the associated objects.
     *
     * @link https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_delete.php
     *
     * @param int $contactId
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function delete(int $contactId): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.contact.delete',
                [
                    'id' => $contactId,
                ]
            )
        );
    }

    /**
     * Returns the description of contact
     *
     * @link https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_fields.php
     *
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.contact.fields'));
    }

    /**
     * Returns a contact by the specified contact ID
     *
     * @link https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_get.php
     *
     * @param int $contactId
     *
     * @return ContactResult
     * @throws BaseException
     * @throws TransportException
     */
    public function get(int $contactId): ContactResult
    {
        return new ContactResult(
            $this->core->call(
                'crm.contact.get',
                [
                    'id' => $contactId,
                ]
            )
        );
    }

    /**
     * Returns a list of contacts selected by the filter specified as the parameter. See the example for the filter notation.
     *
     * @link https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_list.php
     *
     * @param array{
     *                      ID?: int,
     *                      HONORIFIC?: string,
     *                      NAME?: string,
     *                      SECOND_NAME?: string,
     *                      LAST_NAME?: string,
     *                      PHOTO?: string,
     *                      BIRTHDATE?: string,
     *                      TYPE_ID?: string,
     *                      SOURCE_ID?: string,
     *                      SOURCE_DESCRIPTION?: string,
     *                      POST?: string,
     *                      ADDRESS?: string,
     *                      ADDRESS_2?: string,
     *                      ADDRESS_CITY?: string,
     *                      ADDRESS_POSTAL_CODE?: string,
     *                      ADDRESS_REGION?: string,
     *                      ADDRESS_PROVINCE?: string,
     *                      ADDRESS_COUNTRY?: string,
     *                      ADDRESS_COUNTRY_CODE?: string,
     *                      ADDRESS_LOC_ADDR_ID?: int,
     *                      COMMENTS?: string,
     *                      OPENED?: string,
     *                      EXPORT?: string,
     *                      HAS_PHONE?: string,
     *                      HAS_EMAIL?: string,
     *                      HAS_IMOL?: string,
     *                      ASSIGNED_BY_ID?: string,
     *                      CREATED_BY_ID?: string,
     *                      MODIFY_BY_ID?: string,
     *                      DATE_CREATE?: string,
     *                      DATE_MODIFY?: string,
     *                      COMPANY_ID?: string,
     *                      COMPANY_IDS?: string,
     *                      LEAD_ID?: string,
     *                      ORIGINATOR_ID?: string,
     *                      ORIGIN_ID?: string,
     *                      ORIGIN_VERSION?: string,
     *                      FACE_ID?: int,
     *                      UTM_SOURCE?: string,
     *                      UTM_MEDIUM?: string,
     *                      UTM_CAMPAIGN?: string,
     *                      UTM_CONTENT?: string,
     *                      UTM_TERM?: string,
     *                      PHONE?: string,
     *                      EMAIL?: string,
     *                      WEB?: string,
     *                      IM?: string,
     *                      } $order
     *
     * @param array{
     *                      ID?: int,
     *                      HONORIFIC?: string,
     *                      NAME?: string,
     *                      SECOND_NAME?: string,
     *                      LAST_NAME?: string,
     *                      PHOTO?: string,
     *                      BIRTHDATE?: string,
     *                      TYPE_ID?: string,
     *                      SOURCE_ID?: string,
     *                      SOURCE_DESCRIPTION?: string,
     *                      POST?: string,
     *                      ADDRESS?: string,
     *                      ADDRESS_2?: string,
     *                      ADDRESS_CITY?: string,
     *                      ADDRESS_POSTAL_CODE?: string,
     *                      ADDRESS_REGION?: string,
     *                      ADDRESS_PROVINCE?: string,
     *                      ADDRESS_COUNTRY?: string,
     *                      ADDRESS_COUNTRY_CODE?: string,
     *                      ADDRESS_LOC_ADDR_ID?: int,
     *                      COMMENTS?: string,
     *                      OPENED?: string,
     *                      EXPORT?: string,
     *                      HAS_PHONE?: string,
     *                      HAS_EMAIL?: string,
     *                      HAS_IMOL?: string,
     *                      ASSIGNED_BY_ID?: string,
     *                      CREATED_BY_ID?: string,
     *                      MODIFY_BY_ID?: string,
     *                      DATE_CREATE?: string,
     *                      DATE_MODIFY?: string,
     *                      COMPANY_ID?: string,
     *                      COMPANY_IDS?: string,
     *                      LEAD_ID?: string,
     *                      ORIGINATOR_ID?: string,
     *                      ORIGIN_ID?: string,
     *                      ORIGIN_VERSION?: string,
     *                      FACE_ID?: int,
     *                      UTM_SOURCE?: string,
     *                      UTM_MEDIUM?: string,
     *                      UTM_CAMPAIGN?: string,
     *                      UTM_CONTENT?: string,
     *                      UTM_TERM?: string,
     *                      PHONE?: string,
     *                      EMAIL?: string,
     *                      WEB?: string,
     *                      IM?: string,
     *                      } $filter
     * @param array $select = ['ID','HONORIFIC','NAME','SECOND_NAME','LAST_NAME','PHOTO','BIRTHDATE','TYPE_ID','SOURCE_ID','SOURCE_DESCRIPTION','POST','ADDRESS','ADDRESS_2','ADDRESS_CITY','ADDRESS_POSTAL_CODE','ADDRESS_REGION','ADDRESS_PROVINCE','ADDRESS_COUNTRY','ADDRESS_COUNTRY_CODE','ADDRESS_LOC_ADDR_ID','COMMENTS','OPENED','EXPORT','HAS_PHONE','HAS_EMAIL','HAS_IMOL','ASSIGNED_BY_ID','CREATED_BY_ID','MODIFY_BY_ID','DATE_CREATE','DATE_MODIFY','COMPANY_ID','COMPANY_IDS','LEAD_ID','ORIGINATOR_ID','ORIGIN_ID','ORIGIN_VERSION','FACE_ID','UTM_SOURCE','UTM_MEDIUM','UTM_CAMPAIGN','UTM_CONTENT','UTM_TERM','PHONE','EMAIL','WEB','IM']
     * @param int   $start
     *
     * @return ContactsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function list(array $order, array $filter, array $select, int $start): ContactsResult
    {
        return new ContactsResult(
            $this->core->call(
                'crm.contact.list',
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
     * @param int $contactId
     * @param array{
     *                      ID?: int,
     *                      HONORIFIC?: string,
     *                      NAME?: string,
     *                      SECOND_NAME?: string,
     *                      LAST_NAME?: string,
     *                      PHOTO?: string,
     *                      BIRTHDATE?: string,
     *                      TYPE_ID?: string,
     *                      SOURCE_ID?: string,
     *                      SOURCE_DESCRIPTION?: string,
     *                      POST?: string,
     *                      ADDRESS?: string,
     *                      ADDRESS_2?: string,
     *                      ADDRESS_CITY?: string,
     *                      ADDRESS_POSTAL_CODE?: string,
     *                      ADDRESS_REGION?: string,
     *                      ADDRESS_PROVINCE?: string,
     *                      ADDRESS_COUNTRY?: string,
     *                      ADDRESS_COUNTRY_CODE?: string,
     *                      ADDRESS_LOC_ADDR_ID?: int,
     *                      COMMENTS?: string,
     *                      OPENED?: string,
     *                      EXPORT?: string,
     *                      HAS_PHONE?: string,
     *                      HAS_EMAIL?: string,
     *                      HAS_IMOL?: string,
     *                      ASSIGNED_BY_ID?: string,
     *                      CREATED_BY_ID?: string,
     *                      MODIFY_BY_ID?: string,
     *                      DATE_CREATE?: string,
     *                      DATE_MODIFY?: string,
     *                      COMPANY_ID?: string,
     *                      COMPANY_IDS?: string,
     *                      LEAD_ID?: string,
     *                      ORIGINATOR_ID?: string,
     *                      ORIGIN_ID?: string,
     *                      ORIGIN_VERSION?: string,
     *                      FACE_ID?: int,
     *                      UTM_SOURCE?: string,
     *                      UTM_MEDIUM?: string,
     *                      UTM_CAMPAIGN?: string,
     *                      UTM_CONTENT?: string,
     *                      UTM_TERM?: string,
     *                      PHONE?: string,
     *                      EMAIL?: string,
     *                      WEB?: string,
     *                      IM?: string,
     *                      } $fields
     *
     * @param array{
     *                      REGISTER_SONET_EVENT?: string
     *                      } $params
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function update(int $contactId, array $fields, array $params = []): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.contact.update',
                [
                    'id'     => $contactId,
                    'fields' => $fields,
                    'params' => $params,
                ]
            )
        );
    }

    /**
     * @param array{
     *                      ID?: int,
     *                      HONORIFIC?: string,
     *                      NAME?: string,
     *                      SECOND_NAME?: string,
     *                      LAST_NAME?: string,
     *                      PHOTO?: string,
     *                      BIRTHDATE?: string,
     *                      TYPE_ID?: string,
     *                      SOURCE_ID?: string,
     *                      SOURCE_DESCRIPTION?: string,
     *                      POST?: string,
     *                      ADDRESS?: string,
     *                      ADDRESS_2?: string,
     *                      ADDRESS_CITY?: string,
     *                      ADDRESS_POSTAL_CODE?: string,
     *                      ADDRESS_REGION?: string,
     *                      ADDRESS_PROVINCE?: string,
     *                      ADDRESS_COUNTRY?: string,
     *                      ADDRESS_COUNTRY_CODE?: string,
     *                      ADDRESS_LOC_ADDR_ID?: int,
     *                      COMMENTS?: string,
     *                      OPENED?: string,
     *                      EXPORT?: string,
     *                      HAS_PHONE?: string,
     *                      HAS_EMAIL?: string,
     *                      HAS_IMOL?: string,
     *                      ASSIGNED_BY_ID?: string,
     *                      CREATED_BY_ID?: string,
     *                      MODIFY_BY_ID?: string,
     *                      DATE_CREATE?: string,
     *                      DATE_MODIFY?: string,
     *                      COMPANY_ID?: string,
     *                      COMPANY_IDS?: string,
     *                      LEAD_ID?: string,
     *                      ORIGINATOR_ID?: string,
     *                      ORIGIN_ID?: string,
     *                      ORIGIN_VERSION?: string,
     *                      FACE_ID?: int,
     *                      UTM_SOURCE?: string,
     *                      UTM_MEDIUM?: string,
     *                      UTM_CAMPAIGN?: string,
     *                      UTM_CONTENT?: string,
     *                      UTM_TERM?: string,
     *                      PHONE?: string,
     *                      EMAIL?: string,
     *                      WEB?: string,
     *                      IM?: string,
     *                      } $filter
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