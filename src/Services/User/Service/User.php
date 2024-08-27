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

namespace Bitrix24\SDK\Services\User\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\User\Result\UserResult;
use Bitrix24\SDK\Services\User\Result\UsersResult;

#[ApiServiceMetadata(new Scope(['user']))]
class User extends AbstractService
{
    /**
     * Get user entity fields
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/users/user_fields.php
     */
    #[ApiEndpointMetadata(
        'user.fields',
        'https://training.bitrix24.com/rest_help/users/user_fields.php',
        'Get user entity fields'
    )]
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('user.fields'));
    }

    /**
     * Get current user
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/users/user_current.php
     */
    #[ApiEndpointMetadata(
        'user.current',
        'https://training.bitrix24.com/rest_help/users/user_current.php',
        'Get current user'
    )]
    public function current(): UserResult
    {
        return new UserResult($this->core->call('user.current'));
    }

    /**
     * Invites a user. Available only for users with invitation permissions, usually an administrator. Sends a standard account invitation to the user on success.
     *
     * @param array $fields = ['ID','XML_ID','ACTIVE','NAME','LAST_NAME','SECOND_NAME','TITLE','EMAIL','PERSONAL_PHONE','WORK_PHONE','WORK_POSITION','WORK_COMPANY','IS_ONLINE','TIME_ZONE','TIMESTAMP_X','TIME_ZONE_OFFSET','DATE_REGISTER','LAST_ACTIVITY_DATE','PERSONAL_PROFESSION','PERSONAL_GENDER','PERSONAL_BIRTHDAY','PERSONAL_PHOTO','PERSONAL_FAX','PERSONAL_MOBILE','PERSONAL_PAGER','PERSONAL_STREET','PERSONAL_MAILBOX','PERSONAL_CITY','PERSONAL_STATE','PERSONAL_ZIP','PERSONAL_COUNTRY','PERSONAL_NOTES','WORK_DEPARTMENT','WORK_WWW','WORK_FAX','WORK_PAGER','WORK_STREET','WORK_MAILBOX','WORK_CITY','WORK_STATE','WORK_ZIP','WORK_COUNTRY','WORK_PROFILE','WORK_LOGO','WORK_NOTES','UF_DEPARTMENT','UF_DISTRICT','UF_SKYPE','UF_SKYPE_LINK','UF_ZOOM','UF_TWITTER','UF_FACEBOOK','UF_LINKEDIN','UF_XING','UF_WEB_SITES','UF_PHONE_INNER','UF_EMPLOYMENT_DATE','UF_TIMEMAN','UF_SKILLS','UF_INTERESTS','USER_TYPE']
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/users/user_add.php
     */
    #[ApiEndpointMetadata(
        'user.add',
        'https://training.bitrix24.com/rest_help/users/user_add.php',
        'Invites a user. Available only for users with invitation permissions, usually an administrator. Sends a standard account invitation to the user on success.'
    )]
    public function add(array $fields, string $messageText = ''): AddedItemResult
    {
        if (!array_key_exists('EXTRANET', $fields)) {
            throw new InvalidArgumentException('field EXTRANET is required');
        }

        return new AddedItemResult($this->core->call(
            'user.add',
            array_merge(
                $fields,
                [
                    'MESSAGE_TEXT' => $messageText
                ]
            )
        ));
    }

    /**
     * @param array $filter = ['ID','XML_ID','ACTIVE','NAME','LAST_NAME','SECOND_NAME','TITLE','EMAIL','PERSONAL_PHONE','WORK_PHONE','WORK_POSITION','WORK_COMPANY','IS_ONLINE','TIME_ZONE','TIMESTAMP_X','TIME_ZONE_OFFSET','DATE_REGISTER','LAST_ACTIVITY_DATE','PERSONAL_PROFESSION','PERSONAL_GENDER','PERSONAL_BIRTHDAY','PERSONAL_PHOTO','PERSONAL_FAX','PERSONAL_MOBILE','PERSONAL_PAGER','PERSONAL_STREET','PERSONAL_MAILBOX','PERSONAL_CITY','PERSONAL_STATE','PERSONAL_ZIP','PERSONAL_COUNTRY','PERSONAL_NOTES','WORK_DEPARTMENT','WORK_WWW','WORK_FAX','WORK_PAGER','WORK_STREET','WORK_MAILBOX','WORK_CITY','WORK_STATE','WORK_ZIP','WORK_COUNTRY','WORK_PROFILE','WORK_LOGO','WORK_NOTES','UF_DEPARTMENT','UF_DISTRICT','UF_SKYPE','UF_SKYPE_LINK','UF_ZOOM','UF_TWITTER','UF_FACEBOOK','UF_LINKEDIN','UF_XING','UF_WEB_SITES','UF_PHONE_INNER','UF_EMPLOYMENT_DATE','UF_TIMEMAN','UF_SKILLS','UF_INTERESTS','USER_TYPE']
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'user.get',
        'https://training.bitrix24.com/rest_help/users/user_get.php',
        'Get user by id'
    )]
    public function get(array $order, array $filter, bool $isAdminMode = false): UsersResult
    {
        if ($order === []) {
            $order = ['ID' => 'ASC'];
        }

        return new UsersResult($this->core->call('user.get', [
            'sort' => array_keys($order)[0],
            'order' => array_values($order)[0],
            'filter' => $filter,
            'ADMIN_MODE' => $isAdminMode ? 'true' : 'false'
        ]));
    }

    /**
     * Updates user information. Available only for users with invitation permissions.
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/users/user_update.php
     */
    #[ApiEndpointMetadata(
        'user.update',
        'https://training.bitrix24.com/rest_help/users/user_get.php',
        'Updates user information. Available only for users with invitation permissions.'
    )]
    public function update(int $userId, array $fields): UpdatedItemResult
    {
        return new UpdatedItemResult($this->core->call('user.update', array_merge(
            $fields,
            [
                'ID' => $userId
            ]
        )));
    }

    /**
     * This method is used to retrieve list of users with expedited personal data search (name, last name, middle name, name of department, position). Works in two modes: Quick mode, via Fulltext Index and slower mode via right LIKE (support is determined automatically).
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/users/user_search.php
     */
    #[ApiEndpointMetadata(
        'user.search',
        'https://training.bitrix24.com/rest_help/users/user_search.php',
        'This method is used to retrieve list of users with expedited personal data search.'
    )]
    public function search(array $filterFields): UsersResult
    {
        return new UsersResult($this->core->call('user.search', $filterFields));
    }
}