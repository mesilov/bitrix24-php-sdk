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
use Bitrix24\SDK\Services\CRM\Deal\Result\DealContactItemsResult;

/**
 * Class DealContact
 *
 * @package Bitrix24\SDK\Services\CRM\Deal\Service
 */
class DealContact extends AbstractService
{
    /**
     * Adds contact to specified deal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_add.php
     *
     * @param int  $dealId
     * @param int  $contactId
     * @param bool $isPrimary
     * @param int  $sort
     *
     * @return AddedItemResult
     * @throws TransportException
     * @throws BaseException
     */
    public function add(int $dealId, int $contactId, bool $isPrimary, int $sort = 100): AddedItemResult
    {
        return new AddedItemResult(
            $this->core->call(
                'crm.deal.contact.add',
                [
                    'id'     => $dealId,
                    'fields' => [
                        'CONTACT_ID' => $contactId,
                        'IS_PRIMARY' => $isPrimary,
                        'SORT'       => $sort,
                    ],
                ]
            )
        );
    }

    /**
     * Returns field descriptions for the deal-contact link used by methods of family crm.deal.contact.*
     *
     * @link  https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_fields.php
     * @return FieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.deal.contact.fields'));
    }

    /**
     * Returns a set of contacts, associated with the specified deal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_items_get.php
     *
     * @param int $dealId
     *
     * @return DealContactItemsResult
     * @throws BaseException
     * @throws TransportException
     */
    public function itemsGet(int $dealId): DealContactItemsResult
    {
        return new DealContactItemsResult(
            $this->core->call(
                'crm.deal.contact.items.get',
                [
                    'id' => $dealId,
                ]
            )
        );
    }

    /**
     * Clears a set of contacts, associated with the specified deal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_items_delete.php
     *
     * @param int $dealId
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function itemsDelete(int $dealId): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.deal.contact.items.delete',
                [
                    'id' => $dealId,
                ]
            )
        );
    }

    /**
     * Set a set of contacts, associated with the specified seal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_items_set.php
     *
     * @param int $dealId
     * @param array<int, array{
     *   CONTACT_ID: int,
     *   SORT: int,
     *   IS_PRIMARY: string,
     *   }> $contactItems
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function itemsSet(int $dealId, array $contactItems): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.deal.contact.items.set',
                [
                    'id'    => $dealId,
                    'items' => $contactItems,
                ]
            )
        );
    }

    /**
     * Deletes contact from a specified deal
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_delete.php
     *
     * @param int $dealId
     * @param int $contactId
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    public function delete(int $dealId, int $contactId): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.deal.contact.delete',
                [
                    'id'     => $dealId,
                    'fields' => [
                        'CONTACT_ID' => $contactId,
                    ],
                ]
            )
        );
    }
}