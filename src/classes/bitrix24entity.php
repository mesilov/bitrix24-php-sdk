<?php

namespace Bitrix24;

/**
 * Class Bitrix24Entity.
 */
abstract class bitrix24entity
{
    const ITEMS_PER_PAGE_LIMIT = 50;

    /**
     * @var Bitrix24
     */
    public $client = null;

    /**
     * @param $client Bitrix24
     */
    public function __construct(Bitrix24 $client)
    {
        $this->client = $client;
    }
}
