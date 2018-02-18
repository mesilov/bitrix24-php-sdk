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
 * Class User
 *
 * @package Bitrix24\FaceTracker
 */
class User extends Bitrix24Entity
{
    /**
     * add user face to client library
     *
     * @param $userId    int user identifier
     * @param $userPhoto string client base64 encoding photo
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function add($userId, $userPhoto)
    {
        return $this->client->call('face.user.add',
            array(
                'PHOTO' => $userPhoto,
                'USER_ID' => $userId,
            )
        );
    }

    /**
     * find user face in user gallery
     *
     * @see https://dev.1c-bitrix.ru/rest_help/faceid/face_user_identify.php
     *
     * @param $clientPhoto string client base64 encoding photo
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function identify($clientPhoto)
    {
        return $this->client->call('face.user.identify',
            array(
                'PHOTO' => $clientPhoto,
            )
        );
    }

    /**
     * delete face from user gallery
     *
     * @see https://dev.1c-bitrix.ru/rest_help/faceid/face_user_delete.php
     *
     * @param $faceId
     *
     * @return array
     * @throws Bitrix24Exception
     */
    public function delete($faceId)
    {
        return $this->client->call('face.user.delete',
            array(
                'FACE_ID' => $faceId,
            )
        );
    }
}