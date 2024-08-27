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

namespace Bitrix24\SDK\Services\CRM\Contact\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Contact\Result\ContactUserfieldResult;
use Bitrix24\SDK\Services\CRM\Contact\Result\ContactUserfieldsResult;
use Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNameIsTooLongException;

#[ApiServiceMetadata(new Scope(['crm']))]
class ContactUserfield extends AbstractService
{
    /**
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
     * @return ContactUserfieldsResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.contact.userfield.list',
        'https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_list.php',
        'Returns list of user custom fields for contacts by filter. Prints information about these fields, only identifier and without a title assigned to the field by the user. '
    )]
    public function list(array $order, array $filter): ContactUserfieldsResult
    {
        return new ContactUserfieldsResult(
            $this->core->call(
                'crm.contact.userfield.list',
                [
                    'order' => $order,
                    'filter' => $filter,
                ]
            )
        );
    }

    /**
     * Creates a new user field for contacts.
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
     * @return AddedItemResult
     * @throws BaseException
     * @throws TransportException
     * @throws UserfieldNameIsTooLongException
     * @link https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_add.php
     *
     */
    #[ApiEndpointMetadata(
        'crm.contact.userfield.add',
        'https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_add.php',
        'Creates a new user field for contacts.'
    )]
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
                'crm.contact.userfield.add',
                [
                    'fields' => $userfieldItemFields,
                ]
            )
        );
    }

    /**
     * Deleted user field for contacts.
     *
     * @param int $userfieldId
     *
     * @return \Bitrix24\SDK\Core\Result\DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     * @link  https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_delete.php
     *
     */
    #[ApiEndpointMetadata(
        'crm.contact.userfield.delete',
        'https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_delete.php',
        'Delete a user by Id'
    )]
    public function delete(int $userfieldId): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call(
                'crm.contact.userfield.delete',
                [
                    'id' => $userfieldId,
                ]
            )
        );
    }

    /**
     * Returns a user field for contacts by ID.
     *
     * @param int $contactUserfieldItemId
     *
     * @return ContactUserfieldResult
     * @throws BaseException
     * @throws TransportException
     * @link  https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_get.php
     */
    #[ApiEndpointMetadata(
        'crm.contact.userfield.get',
        'https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_get.php',
        'Get a user by Id'
    )]
    public function get(int $contactUserfieldItemId): ContactUserfieldResult
    {
        return new ContactUserfieldResult(
            $this->core->call(
                'crm.contact.userfield.get',
                [
                    'id' => $contactUserfieldItemId,
                ]
            )
        );
    }

    /**
     * Updates an existing user field for contacts.
     *
     * @param int $contactUserfieldItemId
     * @param array $userfieldFieldsToUpdate
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_update.php
     */
    #[ApiEndpointMetadata(
        'crm.contact.userfield.update',
        'https://training.bitrix24.com/rest_help/crm/contacts/crm_contact_userfield_update.php',
        'Update a user by Id'
    )]
    public function update(int $contactUserfieldItemId, array $userfieldFieldsToUpdate): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.contact.userfield.update',
                [
                    'id' => $contactUserfieldItemId,
                    'fields' => $userfieldFieldsToUpdate,
                ]
            )
        );
    }
}