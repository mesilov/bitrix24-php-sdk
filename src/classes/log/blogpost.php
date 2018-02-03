<?php
namespace Bitrix24\Log;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class BlogPost extends  Bitrix24Entity
{
    /**
     * @param $order
     * @param $filter
     * @link https://dev.1c-bitrix.ru/rest_help/log/log_blogpost_get.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function Get($order, $filter)
    {
        $result = $this->client->call('log.blogpost.get',
            array(
                'ORDER' => $order,
                'FILTER'=> $filter,
            ));
        return $result;
    }

    /**
     * @param $message
     * @param $title
     * @param $perm
     * @link https://dev.1c-bitrix.ru/rest_help/log/log_blogpost_add.php
     * @throws Bitrix24Exception
     * @return array
     */
    public function Add($message='', $title='', $perm=array("UA"))
    {
        $result = $this->client->call(
            'log.blogpost.add',
            array(
                'POST_MESSAGE' => $message,
                'POST_TITLE' => $title,
                'SPERM' => $perm
            )
        );
        return $result;
    }
}