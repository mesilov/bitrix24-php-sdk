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

namespace Bitrix24\SDK\Services\Placement\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Placement\Result\DeleteUserTypeResult;
use Bitrix24\SDK\Services\Placement\Result\RegisterUserTypeResult;
use Bitrix24\SDK\Services\Placement\Result\UserFieldTypesResult;
#[ApiServiceMetadata(new Scope(['placement']))]
class UserFieldType extends AbstractService
{
    /**
     * Registration of new type of user fields. This method returns true or an error with description.
     *
     * @param string $userTypeId  Inline code of the type. Required parameter. a-z0-9
     * @param string $handlerUrl  Address of user type handler. Required parameter. Shall be in the same domain as the main application address.
     * @param string $title       Type text name. Will be displayed in the admin interface of user field settings.
     * @param string $description Type text description. Will be displayed in the admin interface of user field settings.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/user_field/userfieldtype_add.php
     */
    #[ApiEndpointMetadata(
        'userfieldtype.add',
        'https://training.bitrix24.com/rest_help/application_embedding/user_field/userfieldtype_add.php',
        'Registration of new type of user fields. This method returns true or an error with description.'
    )]
    public function add(string $userTypeId, string $handlerUrl, string $title, string $description): RegisterUserTypeResult
    {
        return new RegisterUserTypeResult(
            $this->core->call(
                'userfieldtype.add',
                [
                    'USER_TYPE_ID' => $userTypeId,
                    'HANDLER'      => $handlerUrl,
                    'TITLE'        => $title,
                    'DESCRIPTION'  => $description,
                ]
            )
        );
    }

    /**
     * Retrieves list of user field types, registrered by the application. List method. Results in the list of field types with page-by-page navigation.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/user_field/userfieldtype_list.php
     */
    #[ApiEndpointMetadata(
        'userfieldtype.list',
        'https://training.bitrix24.com/rest_help/application_embedding/user_field/userfieldtype_list.php',
        'Retrieves list of user field types, registrered by the application. List method. Results in the list of field types with page-by-page navigation.'
    )]
    public function list(): UserFieldTypesResult
    {
        return new UserFieldTypesResult(
            $this->core->call('userfieldtype.list')
        );
    }

    /**
     * Modifies settings of user field types, registered by the application. This method returns true or an error with description.
     *
     * @param string $userTypeId  Inline code of the type. Required parameter. a-z0-9
     * @param string $handlerUrl  Address of user type handler. Required parameter. Shall be in the same domain as the main application address.
     * @param string $title       Type text name. Will be displayed in the admin interface of user field settings.
     * @param string $description Type text description. Will be displayed in the admin interface of user field settings.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/user_field/userfieldtype_update.php
     */
    #[ApiEndpointMetadata(
        'userfieldtype.update',
        'https://training.bitrix24.com/rest_help/application_embedding/user_field/userfieldtype_update.php',
        'Modifies settings of user field types, registered by the application. This method returns true or an error with description.'
    )]
    public function update(string $userTypeId, string $handlerUrl, string $title, string $description): RegisterUserTypeResult
    {
        return new RegisterUserTypeResult(
            $this->core->call(
                'userfieldtype.update',
                [
                    'USER_TYPE_ID' => $userTypeId,
                    'HANDLER'      => $handlerUrl,
                    'TITLE'        => $title,
                    'DESCRIPTION'  => $description,
                ]
            )
        );
    }

    /**
     * Deletes user field type, registered by the application. This method returns true or an error with description.
     *
     * @param string $userTypeId Inline code of the type. Required parameter. a-z0-9
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/user_field/userfieldtype_delete.php
     */
    #[ApiEndpointMetadata(
        'userfieldtype.delete',
        'https://training.bitrix24.com/rest_help/application_embedding/user_field/userfieldtype_delete.php',
        'Deletes user field type, registered by the application. This method returns true or an error with description.'
    )]
    public function delete(string $userTypeId): DeleteUserTypeResult
    {
        return new DeleteUserTypeResult(
            $this->core->call(
                'userfieldtype.delete',
                [
                    'USER_TYPE_ID' => $userTypeId,
                ]
            )
        );
    }
}