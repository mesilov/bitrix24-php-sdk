<?php

namespace Bitrix24\Sonet;

use Bitrix24\Bitrix24Entity;

class sonetgroup extends Bitrix24Entity
{
    /**
     * @param $ORDER
     * @param $FILTER
     *
     * @return array
     */
    public function Get($ORDER, $FILTER)
    {
        /*
         * @todo add a full result return support
         */
        $result = $this->client->call('sonet_group.get',
            [
                'ORDER'  => $ORDER,
                'FILTER' => $FILTER,
            ]);

        return $result;
    }
}
