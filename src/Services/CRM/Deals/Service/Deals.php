<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deals\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;
use Generator;

/**
 * Class Deals
 *
 * @package Bitrix24\SDK\Services\CRM\Deals\Client
 */
class Deals extends AbstractService
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

        $result = $this->batch->getTraversableList('crm.deal.list', $order, $filter, $select, $limit);

        $this->log->debug('getTraversableList.finish');

        return $result;
    }

    /**
     * Get list of deal items.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_list.php
     *
     * @param array   $order     - order of deal items
     * @param array   $filter    - filter array
     * @param array   $select    - array of collumns to select
     * @param integer $startItem - entity number to start from (usually returned in 'next' field of previous 'crm.deal.list' API call)
     *
     * @return Response
     */
    public function list(array $order, array $filter, array $select, int $startItem = 0): Response
    {
        $this->log->debug(
            'deals.list.start',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => $startItem,
            ]
        );

        $result = $this->core->call(
            'crm.deal.list',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => $startItem,
            ]
        );
        $this->log->debug('deals.list.finish');

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
    public function add(array $fields, array $params = []): Response
    {
        $this->log->debug(
            'add.start',
            [
                'fields' => $fields,
                'params' => $params,
            ]
        );

        $result = $this->core->call(
            'crm.deal.add',
            [
                'fields' => $fields,
                'params' => $params,
            ]
        );

        $this->log->debug('add.finish');

        return $result;
    }

    /**
     * @param int $id
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function get(int $id): Response
    {
        $this->log->debug(
            'get.start',
            [
                'id' => $id,
            ]
        );

        $response = $this->core->call('crm.deal.get', ['id' => $id]);

        $this->log->debug('get.finish');

        return $response;
    }
}