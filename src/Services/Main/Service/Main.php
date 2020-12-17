<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;

/**
 * Class Main
 *
 * @package Bitrix24\SDK\Services
 */
class Main extends AbstractService
{
    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getCurrentScope(): Response
    {
        $this->log->debug('getCurrentScope.start');

        $result = $this->core->call('scope');

        $this->log->debug('getCurrentScope.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getAvailableScope(): Response
    {
        $this->log->debug('getAvailableScope.start');

        $result = $this->core->call('scope', ['full' => true]);

        $this->log->debug('getAvailableScope.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getAvailableMethods(): Response
    {
        $this->log->debug('getAvailableMethods.start');

        $result = $this->core->call('methods', []);

        $this->log->debug('getAvailableMethods.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getAllMethods(): Response
    {
        $this->log->debug('getAllMethods.start');

        $result = $this->core->call('methods', ['full' => true]);

        $this->log->debug('getAllMethods.finish');

        return $result;
    }

    /**
     * @param string $scope
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getMethodsByScope(string $scope): Response
    {
        $this->log->debug(
            'getMethodsByScope.start',
            [
                'scope' => $scope,
            ]
        );

        $result = $this->core->call('methods', ['scope' => $scope]);

        $this->log->debug('getMethodsByScope.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getApplicationInfo(): Response
    {
        $this->log->debug('getApplicationInfo.start');

        $result = $this->core->call('app.info');

        $this->log->debug('getApplicationInfo.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function isCurrentUserHasAdminRights(): Response
    {
        $this->log->debug('isCurrentUserHasAdminRights.start');

        $result = $this->core->call('user.admin');

        $this->log->debug('isCurrentUserHasAdminRights.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getUserProfile(): Response
    {
        $this->log->debug('getUserProfile.start');

        $result = $this->core->call('profile');

        $this->log->debug('getUserProfile.finish');

        return $result;
    }
}