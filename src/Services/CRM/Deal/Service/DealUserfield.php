<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealUserfieldResult;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealUserfieldsResult;
use Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNameIsTooLongException;

class DealUserfield extends AbstractService
{
    /**
     * Returns list of user deal fields by filter.
     *
     * @param array{
     *   ID?: string,
     *   ENTITY_ID?: string,
     *   FIELD_NAME?: string,
     *   USER_TYPE_ID?: string,
     *   XML_ID?: string,
     *   SORT?: string,
     *   MULTIPLE?: string,
     *   MANDATORY?: string,
     *   SHOW_FILTER?: string,
     *   SHOW_IN_LIST?: string,
     *   EDIT_IN_LIST?: string,
     *   IS_SEARCHABLE?: string,
     *   EDIT_FORM_LABEL?: string,
     *   LIST_COLUMN_LABEL?: string,
     *   LIST_FILTER_LABEL?: string,
     *   ERROR_MESSAGE?: string,
     *   HELP_MESSAGE?: string,
     *   LIST?: string,
     *   SETTINGS?: string,
     *   } $order
     * @param array{
     *   ID?: string,
     *   ENTITY_ID?: string,
     *   FIELD_NAME?: string,
     *   USER_TYPE_ID?: string,
     *   XML_ID?: string,
     *   SORT?: string,
     *   MULTIPLE?: string,
     *   MANDATORY?: string,
     *   SHOW_FILTER?: string,
     *   SHOW_IN_LIST?: string,
     *   EDIT_IN_LIST?: string,
     *   IS_SEARCHABLE?: string,
     *   EDIT_FORM_LABEL?: string,
     *   LIST_COLUMN_LABEL?: string,
     *   LIST_FILTER_LABEL?: string,
     *   ERROR_MESSAGE?: string,
     *   HELP_MESSAGE?: string,
     *   LIST?: string,
     *   SETTINGS?: string,
     *   } $filter
     *
     * @return \Bitrix24\SDK\Services\CRM\Deal\Result\DealUserfieldsResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_userfield_list.php
     */
    public function list(array $order, array $filter): DealUserfieldsResult
    {
        return new DealUserfieldsResult(
            $this->core->call(
                'crm.deal.userfield.list',
                [
                    'order'  => $order,
                    'filter' => $filter,
                ]
            )
        );
    }

    /**
     * Created new user field for deals.
     *
     * System limitation for field name - 20 characters.
     * Prefix UF_CRM_is always added to the user field name.
     * As a result, the actual name length - 13 characters.
     *
     * @param array{
     *   FIELD_NAME?: string,
     *   USER_TYPE_ID?: string,
     *   XML_ID?: string,
     *   SORT?: string,
     *   MULTIPLE?: string,
     *   MANDATORY?: string,
     *   SHOW_FILTER?: string,
     *   SHOW_IN_LIST?: string,
     *   EDIT_IN_LIST?: string,
     *   IS_SEARCHABLE?: string,
     *   EDIT_FORM_LABEL?: string,
     *   LIST_COLUMN_LABEL?: string,
     *   LIST_FILTER_LABEL?: string,
     *   ERROR_MESSAGE?: string,
     *   HELP_MESSAGE?: string,
     *   LIST?: string,
     *   SETTINGS?: string,
     *   } $userfieldItemFields
     *
     * @return \Bitrix24\SDK\Core\Result\AddedItemResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws UserfieldNameIsTooLongException
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_userfield_add.php
     *
     */
    public function add(array $userfieldItemFields): AddedItemResult
    {
        if (strlen($userfieldItemFields['FIELD_NAME']) > 13) {
            throw new UserfieldNameIsTooLongException(
                sprintf(
                    'userfield name %s is too long %s, maximum length - 13 characters',
                    $userfieldItemFields['FIELD_NAME'],
                    strlen($userfieldItemFields['FIELD_NAME'])
                )
            );
        }

        return new AddedItemResult(
            $this->core->call(
                'crm.deal.userfield.add',
                [
                    'fields' => $userfieldItemFields,
                ]
            )
        );
    }

    /**
     * Deleted userfield for deals
     *
     * @param int $userfieldId
     *
     * @return \Bitrix24\SDK\Core\Result\DeletedItemResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link  https://training.bitrix24.com/rest_help/crm/deals/crm_deal_userfield_delete.php
     *
     */
    public function delete(int $userfieldId): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.deal.userfield.delete',
                [
                    'id' => $userfieldId,
                ]
            )
        );
    }

    /**
     * Returns a userfield for deal by ID.
     *
     * @param int $userfieldItemId
     *
     * @return \Bitrix24\SDK\Services\CRM\Deal\Result\DealUserfieldResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link  https://training.bitrix24.com/rest_help/crm/deals/crm_deal_userfield_get.php
     */
    public function get(int $userfieldItemId): DealUserfieldResult
    {
        return new DealUserfieldResult(
            $this->core->call(
                'crm.deal.userfield.get',
                [
                    'id' => $userfieldItemId,
                ]
            )
        );
    }

    /**
     * Updates an existing user field for deals.
     *
     * @param int   $userfieldItemId
     * @param array $userfieldFieldsToUpdate
     *
     * @return \Bitrix24\SDK\Core\Result\UpdatedItemResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_userfield_update.php
     */
    public function update(int $userfieldItemId, array $userfieldFieldsToUpdate): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.deal.userfield.update',
                [
                    'id'     => $userfieldItemId,
                    'fields' => $userfieldFieldsToUpdate,
                ]
            )
        );
    }
}