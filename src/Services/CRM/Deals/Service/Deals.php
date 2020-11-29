<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deals\Service;

use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;

/**
 * Class Deals
 *
 * @package Bitrix24\SDK\Services\CRM\Deals\Client
 */
class Deals extends AbstractService
{
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
     * @return int
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function add(array $fields, array $params = []): int
    {
        $this->log->debug(
            'deals.add.start',
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

        $this->log->debug('deals.add.finish');

        return $result->getResponseData()->getResult()->getResultData()[0];
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function get(int $id): array
    {
        $this->log->debug(
            'deals.get.start',
            [
                'id' => $id,
            ]
        );

        $response = $this->core->call('crm.deal.get', ['id' => $id]);

        $this->log->debug('deals.get.finish');

        return $response->getResponseData()->getResult()->getResultData();
    }
}