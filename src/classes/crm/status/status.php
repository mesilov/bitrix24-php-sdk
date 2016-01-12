<?php

namespace Bitrix24\CRM;

use Bitrix24\Bitrix24Entity;

class Status extends Bitrix24Entity
{
    /**
     * get list of dictionary fields descriptions
     * @link https://dev.1c-bitrix.ru/rest_help/crm/auxiliary/status/index.php
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.status.fields'
        );
        return $fullResult;
    }

    /**
     * get list of dictionary types
     * @link https://dev.1c-bitrix.ru/rest_help/crm/auxiliary/status/crm_status_entity_types.php
     * @return array
     */
    public function entityTypes()
    {
        $fullResult = $this->client->call(
            'crm.status.entity.types'
        );
        return $fullResult;
    }

    /**
     * get dictionary data
     * @link https://dev.1c-bitrix.ru/rest_help/crm/auxiliary/status/crm_status_entity_items.php
     * @param string $entityId
     * @return array
     */
    public function entityItems($entityId)
    {
        $fullResult = $this->client->call(
            'crm.status.entity.items',
            array(
                'entityId' => $entityId
            )
        );
        return $fullResult;
    }
}
