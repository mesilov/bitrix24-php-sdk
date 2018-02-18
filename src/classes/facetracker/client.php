<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\FaceTracker;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Exceptions\Bitrix24Exception;

/**
 * Class Client
 *
 * @package Bitrix24\FaceTracker
 */
class Client extends Bitrix24Entity
{
    /**
     * add client face to client library
     *
     * @see https://dev.1c-bitrix.ru/rest_help/faceid/face_client_add.php
     *
     * @param $clientPhoto string client base64 encoding photo
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function add($clientPhoto)
    {
        return $this->client->call('face.client.add', array('PHOTO' => $clientPhoto));
    }

    /**
     * find client face in client gallery
     *
     * @see https://dev.1c-bitrix.ru/rest_help/faceid/face_client_identify.php
     *
     * @param $clientPhoto string client base64 encoding photo
     * @param $isForceAdd
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function identify($clientPhoto, $isForceAdd)
    {
        return $this->client->call('face.client.identify',
            array(
                'PHOTO' => $clientPhoto,
                'FORCE_ADD' => $isForceAdd === true ? 'Y' : 'N',
            )
        );
    }
}