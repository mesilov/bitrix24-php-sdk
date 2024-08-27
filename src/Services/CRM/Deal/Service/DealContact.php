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

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealContactItemsResult;

#[ApiServiceMetadata(new Scope(['crm']))]
class DealContact extends AbstractService
{
    /**
     * Adds contact to specified deal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_add.php
     *
     * @param int $dealId
     * @param int $contactId
     * @param bool $isPrimary
     * @param int $sort
     *
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.contact.add',
        'https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_stage_list.php',
        'Adds contact to specified deal.'
    )]
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
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.contact.fields',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_fields.php',
        'Returns field descriptions for the deal-contact link used by methods of family crm.deal.contact.*'
    )]
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
    #[ApiEndpointMetadata(
        'crm.deal.contact.items.get',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_items_get.php',
        'Returns a set of contacts, associated with the specified deal.'
    )]
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
    #[ApiEndpointMetadata(
        'crm.deal.contact.items.delete',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_items_delete.php',
        'Clears a set of contacts, associated with the specified deal.'
    )]
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
    #[ApiEndpointMetadata(
        'crm.deal.contact.items.set',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_items_set.php',
        'Set a set of contacts, associated with the specified seal.'
    )]
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
    #[ApiEndpointMetadata(
        'crm.deal.contact.delete',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_contact_items_set.php',
        'Deletes contact from a specified deal'
    )]
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