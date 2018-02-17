<?php

namespace Bitrix24\CRM\DealCategory;

use Bitrix24\Bitrix24Entity;

class Stage extends Bitrix24Entity
{
    /**
     * Get list of deal category stages.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/category/crm_dealcategory_stage_list.php
     * @param int $id - deal category id
     * @return array
     */
    public function getList($id)
    {
        $fullResult = $this->client->call(
            'crm.dealcategory.stage.list',
            array(
                'id' => $id,
            )
        );

        return $fullResult;
    }
}
