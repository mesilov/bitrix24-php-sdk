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

namespace Bitrix24\SDK\Services\Main\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Main\Result\ApplicationInfoResult;
use Bitrix24\SDK\Services\Main\Result\IsUserAdminResult;
use Bitrix24\SDK\Services\Main\Result\MethodAffordabilityResult;
use Bitrix24\SDK\Services\Main\Result\ServerTimeResult;
use Bitrix24\SDK\Services\Main\Result\UserProfileResult;

#[ApiServiceMetadata(new Scope([]))]
class Main extends AbstractService
{
    /**
     * Method returns current server time in the format YYYY-MM-DDThh:mm:ss±hh:mm.
     *
     * @link https://training.bitrix24.com/rest_help/general/server_time.php
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'server.time',
        'https://training.bitrix24.com/rest_help/general/server_time.php',
        'Method returns current server time in the format YYYY-MM-DDThh:mm:ss±hh:mm.'
    )]
    public function getServerTime(): ServerTimeResult
    {
        return new ServerTimeResult($this->core->call('server.time'));
    }

    /**
     * Allows to return basic Information about the current user without any scopes, in contrast to user.current.
     *
     * @link https://training.bitrix24.com/rest_help/general/profile.php
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'profile',
        'https://training.bitrix24.com/rest_help/general/profile.php',
        'Allows to return basic Information about the current user without any scopes, in contrast to user.current.'
    )]
    public function getCurrentUserProfile(): UserProfileResult
    {
        return new UserProfileResult($this->core->call('profile'));
    }

    /**
     * Returns access permission names.
     *
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/access_name.php
     */
    #[ApiEndpointMetadata(
        'access.name',
        'https://training.bitrix24.com/rest_help/general/access_name.php',
        'Returns access permission names.'
    )]
    public function getAccessName(array $accessList): Response
    {
        return $this->core->call('access.name', [
            'ACCESS' => $accessList,
        ]);
    }

    /**
     * Checks if the current user has at least one permission of those specified by the ACCESS parameter.
     *
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/user_access.php
     */
    #[ApiEndpointMetadata(
        'user.access',
        'https://training.bitrix24.com/rest_help/general/user_access.php',
        'Checks if the current user has at least one permission of those specified by the ACCESS parameter.'
    )]
    public function checkUserAccess(array $accessToCheck): Response
    {
        return $this->core->call('user.access', [
            'ACCESS' => $accessToCheck,
        ]);
    }

    /**
     * Method returns 2 parameters - isExisting and isAvailable
     *
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/method_get.php
     */
    #[ApiEndpointMetadata(
        'method.get',
        'https://training.bitrix24.com/rest_help/general/method_get.php',
        'Method returns 2 parameters - isExisting and isAvailable'
    )]
    public function getMethodAffordability(string $methodName): MethodAffordabilityResult
    {
        return new MethodAffordabilityResult(
            $this->core->call('method.get', [
                'name' => $methodName,
            ])
        );
    }

    /**
     * It will return permissions available to the current application.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/scope.php
     */
    #[ApiEndpointMetadata(
        'scope',
        'https://training.bitrix24.com/rest_help/general/scope.php',
        'Method returns 2 parameters - isExisting and isAvailable'
    )]
    public function getCurrentScope(): Response
    {
        return $this->core->call('scope');
    }

    /**
     * Method will return a list of all possible permissions.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/scope.php
     */
    #[ApiEndpointMetadata(
        'scope',
        'https://training.bitrix24.com/rest_help/general/scope.php',
        'Method will return a list of all possible permissions.'
    )]
    public function getAvailableScope(): Response
    {
        return $this->core->call('scope', ['full' => true]);
    }

    /**
     * Returns the methods available to the current application
     *
     * @throws BaseException
     * @throws TransportException
     * @deprecated use method.get
     * @link       https://training.bitrix24.com/rest_help/general/methods.php
     */
    #[ApiEndpointMetadata(
        'methods',
        'https://training.bitrix24.com/rest_help/general/methods.php',
        'Returns the methods available to the current application'
    )]
    public function getAvailableMethods(): Response
    {
        return $this->core->call('methods', []);
    }

    /**
     * Returns the methods available
     *
     * @throws BaseException
     * @throws TransportException
     * @deprecated use method.get
     * @link       https://training.bitrix24.com/rest_help/general/methods.php
     */
    #[ApiEndpointMetadata(
        'methods',
        'https://training.bitrix24.com/rest_help/general/methods.php',
        'Returns the methods available to the current application'
    )]
    public function getAllMethods(): Response
    {
        return $this->core->call('methods', ['full' => true]);
    }

    /**
     * Returns the methods available to the current application
     *
     *
     * @throws BaseException
     * @throws TransportException
     * @deprecated use method.get
     * @link       https://training.bitrix24.com/rest_help/general/methods.php
     */
    #[ApiEndpointMetadata(
        'methods',
        'https://training.bitrix24.com/rest_help/general/methods.php',
        'Returns the methods available to the current application'
    )]
    public function getMethodsByScope(string $scope): Response
    {
        return $this->core->call('methods', ['scope' => $scope]);
    }

    /**
     * Displays application information. The method supports secure calling convention.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/app_info.php
     */
    #[ApiEndpointMetadata(
        'app.info',
        'https://training.bitrix24.com/rest_help/general/app_info.php',
        'Displays application information. The method supports secure calling convention.'
    )]
    public function getApplicationInfo(): ApplicationInfoResult
    {
        return new ApplicationInfoResult($this->core->call('app.info'));
    }

    /**
     * Checks if a current user has permissions to manage application parameters.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/user_admin.php
     */
    #[ApiEndpointMetadata(
        'user.admin',
        'https://training.bitrix24.com/rest_help/general/user_admin.php',
        'Checks if a current user has permissions to manage application parameters.'
    )]
    public function isCurrentUserHasAdminRights(): IsUserAdminResult
    {
        return new IsUserAdminResult($this->core->call('user.admin'));
    }
}