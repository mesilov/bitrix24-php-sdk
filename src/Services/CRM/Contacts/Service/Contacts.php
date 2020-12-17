<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Contacts\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;
use Generator;

/**
 * Class Contacts
 *
 * @package Bitrix24\SDK\Services\CRM\Contacts\Service
 */
class Contacts extends AbstractService
{
    /**
     * @param array    $order
     * @param array    $filter
     * @param array    $select
     * @param int|null $limit
     *
     * @return Generator
     * @throws BaseException
     */
    public function getTraversableList(array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $this->log->debug(
            'getTraversableList.start',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'limit'  => $limit,
            ]
        );

        $result = $this->batch->getTraversableList('crm.contact.list', $order, $filter, $select, $limit);

        $this->log->debug('getTraversableList.finish');

        return $result;
    }

    /**
     * @param array $fields
     * @param array $params
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function add(array $fields, array $params): Response
    {
        $this->log->debug(
            'add.start',
            [
                'fields' => $fields,
                'params' => $params,
            ]
        );

        $result = $this->core->call(
            'crm.contact.add',
            [
                'fields' => $fields,
                'params' => $params,
            ]
        );


        $this->log->debug('add.finish');

        return $result;
    }

    /**
     * @param int $contactId
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function get(int $contactId): Response
    {
        $this->log->debug(
            'get.start',
            [
                'contactId' => $contactId,
            ]
        );
        $result = $this->core->call(
            'crm.contact.get',
            [
                'id' => $contactId,
            ]
        );

        $this->log->debug('get.finish');

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
            'crm.contact.list',
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
     * @param int   $contactId
     * @param array $fields
     * @param array $params
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function update(int $contactId, array $fields, array $params): Response
    {
        $this->log->debug(
            'update.start',
            [
                'id'     => $contactId,
                'fields' => $fields,
                'params' => $params,
            ]
        );

        $result = $this->core->call(
            'crm.contact.update',
            [
                'id'     => $contactId,
                'fields' => $fields,
                'params' => $params,
            ]
        );

        $this->log->debug('update.finish');

        return $result;
    }

    /**
     * @param int $contactId
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function delete(int $contactId): Response
    {
        $this->log->debug(
            'delete.start',
            [
                'contactId' => $contactId,
            ]
        );

        $result = $this->core->call(
            'crm.contact.delete',
            [
                'id' => $contactId,
            ]
        );


        $this->log->debug('delete.finish');

        return $result;
    }
}