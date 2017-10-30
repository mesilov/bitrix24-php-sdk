<?php

namespace Bitrix24\Placement;

use Bitrix24\Bitrix24Entity;

/**
 * Class Placement
 * @package Bitrix24\Placement
 */
class Placement extends Bitrix24Entity
{
    /**
     * register placement handler
     *
     * @param $placementCode
     * @param $handlerUrl
     * @param $title
     * @param $description
     *
     * @return array
     */
    public function bind($placementCode, $handlerUrl, $title, $description)
    {
        $arResult = $this->client->call('placement.bind',
            array(
                'PLACEMENT' => $placementCode,
                'HANDLER' => $handlerUrl,
                'TITLE' => $title,
                'DESCRIPTION' => $description
            ));
        return $arResult;
    }

    /**
     * unregister placement handler
     *
     * @param $placementCode string
     * @param $handlerUrl string
     *
     * @return array
     */
    public function unbind($placementCode, $handlerUrl)
    {
        $arResult = $this->client->call('placement.unbind',
            array(
                'PLACEMENT' => $placementCode,
                'HANDLER' => $handlerUrl
            ));
        return $arResult;
    }

    /**
     * Get possible placement locations
     *
     * @return array
     */
    public function getPossibleLocations()
    {
        $arResult = $this->client->call('placement.list');
        return $arResult['result'];
    }

    /**
     * get locations with registered placements
     *
     * @return array
     */
    public function getLocations()
    {
        $arResult = $this->client->call('placement.get');
        return $arResult['result'];
    }
}