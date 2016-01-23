<?php

namespace Bitrix24;

class access extends Bitrix24Entity
{
    /**
     * Get access rights names by their codes.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/general/access_name.php
     *
     * @param array $access - list of access rights codes
     *
     * @return array
     */
    public function name($access)
    {
        $result = $this->client->call(
            'access.name',
            [
                'ACCESS' => $access,
            ]
        );

        return $result;
    }
}
