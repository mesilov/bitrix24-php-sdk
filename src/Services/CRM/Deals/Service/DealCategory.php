<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deals\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;

/**
 * Class DealCategory
 *
 * @package Bitrix24\SDK\Services\CRM\Deals\Service
 */
class DealCategory extends AbstractService
{
    /**
     * @param array $fields
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function add(array $fields): Response
    {
        $this->log->debug(
            'add.start',
            [
                'fields' => $fields,
            ]
        );

        $result = $this->core->call(
            'crm.dealcategory.add',
            [
                'fields' => $fields,
            ]
        );

        $this->log->debug('add.finish');

        return $result;
    }

    /**
     * @param int $categoryId
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function delete(int $categoryId): Response
    {
        $this->log->debug(
            'delete.start',
            [
                'categoryId' => $categoryId,
            ]
        );

        $result = $this->core->call(
            'crm.dealcategory.delete',
            [
                'id' => $categoryId,
            ]
        );

        $this->log->debug('delete.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function fields(): Response
    {
        $this->log->debug('fields.start');

        $result = $this->core->call('crm.dealcategory.fields');

        $this->log->debug('fields.finish');

        return $result;
    }

    /**
     * @param int $categoryId
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function get(int $categoryId): Response
    {
        $this->log->debug(
            'get.start',
            [
                'categoryId' => $categoryId,
            ]
        );

        $result = $this->core->call(
            'crm.dealcategory.get',
            [
                'id' => $categoryId,
            ]
        );

        $this->log->debug('get.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getDefaultCategorySettings(): Response
    {
        $this->log->debug(' getDefaultCategorySettings.start');

        $result = $this->core->call('crm.dealcategory.default.get');

        $this->log->debug(' getDefaultCategorySettings.finish');

        return $result;
    }

    /**
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function setDefaultCategoryName(string $name): Response
    {
        $this->log->debug('setDefaultCategoryName.start');

        $result = $this->core->call(
            'crm.dealcategory.default.set',
            [
                'name' => $name,
            ]
        );

        $this->log->debug('setDefaultCategoryName.finish');

        return $result;
    }

    /**
     * @param array $order
     * @param array $filter
     * @param array $select
     * @param int   $start
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function list(array $order, array $filter, array $select, int $start): Response
    {
        $this->log->debug(
            'list.start',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => $start,
            ]
        );

        $result = $this->core->call(
            'crm.dealcategory.list',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => $start,
            ]
        );

        $this->log->debug('list.finish');

        return $result;
    }

    /**
     * @param int $categoryId
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function getStatus(int $categoryId): Response
    {
        $this->log->debug(
            'getStatus.start',
            [
                'categoryId' => $categoryId,
            ]
        );

        $result = $this->core->call(
            'crm.dealcategory.status',
            [
                'id' => $categoryId,
            ]
        );

        $this->log->debug('getStatus.finish');

        return $result;
    }

    /**
     * @param int   $categoryId
     * @param array $fields
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function update(int $categoryId, array $fields): Response
    {
        $this->log->debug(
            'update.start',
            [
                'categoryId' => $categoryId,
                'fields'     => $fields,
            ]
        );

        $result = $this->core->call('crm.dealcategory.update');

        $this->log->debug('update.finish');

        return $result;
    }
}