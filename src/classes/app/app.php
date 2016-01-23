<?php

namespace Bitrix24\App;

use Bitrix24\Bitrix24Entity;

/**
 * Class App.
 */
class app extends Bitrix24Entity
{
    /**
     * Displays application information. The method supports secure calling convention.
     *
     * @link https://training.bitrix24.com/rest_help/general/app_info.php
     *
     * @return array application information
     */
    public function info()
    {
        $result = $this->client->call('app.info', ['state' => $this->client->getSecuritySignSalt()]);

        return $result;
    }
}
