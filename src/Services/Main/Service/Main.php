<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Main\Result\ApplicationInfoResult;
use Bitrix24\SDK\Services\Main\Result\IsUserAdminResult;
use Bitrix24\SDK\Services\Main\Result\MethodAffordabilityResult;
use Bitrix24\SDK\Services\Main\Result\ServerTimeResult;
use Bitrix24\SDK\Services\Main\Result\UserProfileResult;

/**
 * Class Main
 *
 * @package Bitrix24\SDK\Services
 */
class Main extends AbstractService
{
    /**
     * Method returns current server time in the format YYYY-MM-DDThh:mm:ss±hh:mm.
     *
     * @link https://training.bitrix24.com/rest_help/general/server_time.php
     * @return \Bitrix24\SDK\Services\Main\Result\ServerTimeResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function getServerTime(): ServerTimeResult
    {
        return new ServerTimeResult($this->core->call('server.time'));
    }

    /**
     * Allows to return basic Information about the current user without any scopes, in contrast to user.current.
     *
     * @link https://training.bitrix24.com/rest_help/general/profile.php
     * @return \Bitrix24\SDK\Services\Main\Result\UserProfileResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function getCurrentUserProfile(): UserProfileResult
    {
        return new UserProfileResult($this->core->call('profile'));
    }

    /**
     * Returns access permission names.
     *
     * @param array $accessList
     *
     * @return \Bitrix24\SDK\Core\Response\Response
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/general/access_name.php
     */
    public function getAccessName(array $accessList): Response
    {
        return $this->core->call('access.name', [
            'ACCESS' => $accessList,
        ]);
    }

    /**
     * Checks if the current user has at least one permission of those specified by the ACCESS parameter.
     *
     * @param array $accessToCheck
     *
     * @return \Bitrix24\SDK\Core\Response\Response
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/general/user_access.php
     */
    public function checkUserAccess(array $accessToCheck): Response
    {
        return $this->core->call('user.access', [
            'ACCESS' => $accessToCheck,
        ]);
    }

    /**
     * Method returns 2 parameters - isExisting and isAvailable
     *
     * @param string $methodName
     *
     * @return \Bitrix24\SDK\Services\Main\Result\MethodAffordabilityResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/general/method_get.php
     */
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
     * @return Response
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/scope.php
     */
    public function getCurrentScope(): Response
    {
        return $this->core->call('scope');
    }

    /**
     * Method will return a list of all possible permissions.
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/scope.php
     */
    public function getAvailableScope(): Response
    {
        return $this->core->call('scope', ['full' => true]);
    }

    /**
     * Returns the methods available to the current application
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     * @deprecated use method.get
     * @link       https://training.bitrix24.com/rest_help/general/methods.php
     */
    public function getAvailableMethods(): Response
    {
        return $this->core->call('methods', []);
    }

    /**
     * Returns the methods available
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     * @deprecated use method.get
     * @link       https://training.bitrix24.com/rest_help/general/methods.php
     */
    public function getAllMethods(): Response
    {
        return $this->core->call('methods', ['full' => true]);
    }

    /**
     * Returns the methods available to the current application
     *
     * @param string $scope
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     * @deprecated use method.get
     * @link       https://training.bitrix24.com/rest_help/general/methods.php
     */
    public function getMethodsByScope(string $scope): Response
    {
        return $this->core->call('methods', ['scope' => $scope]);
    }

    /**
     * Displays application information. The method supports secure calling convention.
     *
     * @return ApplicationInfoResult
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/app_info.php
     */
    public function getApplicationInfo(): ApplicationInfoResult
    {
        return new ApplicationInfoResult($this->core->call('app.info'));
    }

    /**
     * Checks if a current user has permissions to manage application parameters.
     *
     * @return IsUserAdminResult
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/general/user_admin.php
     */
    public function isCurrentUserHasAdminRights(): IsUserAdminResult
    {
        return new IsUserAdminResult($this->core->call('user.admin'));
    }
}