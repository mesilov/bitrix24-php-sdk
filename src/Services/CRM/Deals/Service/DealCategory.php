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
}