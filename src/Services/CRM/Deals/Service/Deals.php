<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deals\Service;

use Bitrix24\SDK\Services\AbstractService;

/**
 * Class Deals
 *
 * @package Bitrix24\SDK\Services\CRM\Deals\Client
 */
class Deals extends AbstractService
{
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