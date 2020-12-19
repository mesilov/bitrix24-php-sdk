<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Products\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;

/**
 * Class Products
 *
 * @package Bitrix24\SDK\Services\CRM\Products\Service
 */
class Products extends AbstractService
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
        $this->log->debug('add.start', ['fields' => $fields]);

        $result = $this->core->call(
            'crm.product.add',
            [
                'fields' => $fields,
            ]
        );

        $this->log->debug('add.finish');

        return $result;
    }

    /**
     * @param int $productId
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function delete(int $productId): Response
    {
        $this->log->debug(
            'delete.start',
            [
                'id' => $productId,
            ]
        );

        $result = $this->core->call(
            'crm.product.delete',
            [
                'id' => $productId,
            ]
        );


        $this->log->debug('delete.finish');

        return $result;
    }

    /**
     * @param array $order
     * @param array $filter
     * @param array $select
     * @param int   $startItem
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function list(array $order, array $filter, array $select, int $startItem = 0): Response
    {
        $this->log->debug(
            'list.start',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => $startItem,
            ]
        );

        $result = $this->core->call(
            'crm.product.list',
            [
                'order'  => $order,
                'filter' => $filter,
                'select' => $select,
                'start'  => $startItem,
            ]
        );

        $this->log->debug('list.finish');

        return $result;
    }
}