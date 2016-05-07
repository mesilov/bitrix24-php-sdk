<?php
/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com> and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitrix24\Im;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Presets\Im\Fields as B24ImFields;
use Bitrix24\Im\Attach\Attach;

/**
 * Class Notify
 * @package Bitrix24\Im
 */
class Notify extends Bitrix24Entity
{
    /**
     * @param $userId
     * @param $message
     * @param string $tag
     * @param string $subTag
     * @param Attach|null $attachObject
     * @return array
     * @throws Bitrix24Exception
     * @throws \Bitrix24\Bitrix24SecurityException
     * @throws \Bitrix24\Bitrix24Exception
     * @throws \Bitrix24\Bitrix24ApiException
     * @throws \Bitrix24\Bitrix24TokenIsInvalid
     * @throws \Bitrix24\Bitrix24TokenIsExpired
     * @throws \Bitrix24\Bitrix24WrongClientException
     * @throws \Bitrix24\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Bitrix24SecurityException
     */
    public function addPersonal($userId, $message, $tag = '', $subTag = '', Attach $attachObject = null)
    {
        $arArgs = array(
            'user_id' => (int)$userId,
            'message' => (string)$message,
            'tag' => (string)$tag,
            'sub_tag' => (string)$subTag
        );

        if (null === $userId) {
            throw new Bitrix24Exception('user id is null');
        } elseif (null === $message) {
            throw new Bitrix24Exception('message is null');
        } elseif (null !== $attachObject) {
            $arArgs['attach'] = $attachObject->getData();
        }
        return $this->client->call('im.notify.personal.add', $arArgs);
    }

    /**
     * @param $userId
     * @param $message
     * @param string $tag
     * @param string $subTag
     * @param Attach|null $attachObject
     * @return array
     * @throws Bitrix24Exception
     * @throws \Bitrix24\Bitrix24SecurityException
     * @throws \Bitrix24\Bitrix24Exception
     * @throws \Bitrix24\Bitrix24ApiException
     * @throws \Bitrix24\Bitrix24TokenIsInvalid
     * @throws \Bitrix24\Bitrix24TokenIsExpired
     * @throws \Bitrix24\Bitrix24WrongClientException
     * @throws \Bitrix24\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Bitrix24SecurityException
     */
    public function addSystem($userId, $message, $tag = '', $subTag = '', Attach $attachObject = null)
    {
        $arArgs = array(
            'user_id' => (int)$userId,
            'message' => (string)$message,
            'tag' => (string)$tag,
            'sub_tag' => (string)$subTag
        );

        if (null === $userId) {
            throw new Bitrix24Exception('user id is null');
        } elseif (null === $message) {
            throw new Bitrix24Exception('message is null');
        } elseif (null !== $attachObject) {
            $arArgs['attach'] = $attachObject->getData();
        }
        return $this->client->call('im.notify.system.add', $arArgs);
    }

    /**
     * @param $id
     * @return array
     * @throws Bitrix24Exception
     * @throws \Bitrix24\Bitrix24SecurityException
     * @throws \Bitrix24\Bitrix24Exception
     * @throws \Bitrix24\Bitrix24ApiException
     * @throws \Bitrix24\Bitrix24TokenIsInvalid
     * @throws \Bitrix24\Bitrix24TokenIsExpired
     * @throws \Bitrix24\Bitrix24WrongClientException
     * @throws \Bitrix24\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Bitrix24SecurityException
     */
    public function deleteById($id)
    {
        if (null === $id) {
            throw new Bitrix24Exception('id is null');
        }
        $fullResult = $this->client->call(
            'im.notify.delete',
            array(
                'id' => (int)$id
            )
        );
        return $fullResult;
    }

    /**
     * @param $tag
     * @return array
     * @throws Bitrix24Exception
     * @throws \Bitrix24\Bitrix24SecurityException
     * @throws \Bitrix24\Bitrix24Exception
     * @throws \Bitrix24\Bitrix24ApiException
     * @throws \Bitrix24\Bitrix24TokenIsInvalid
     * @throws \Bitrix24\Bitrix24TokenIsExpired
     * @throws \Bitrix24\Bitrix24WrongClientException
     * @throws \Bitrix24\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Bitrix24SecurityException
     */
    public function deleteByTag($tag)
    {
        if (null === $tag) {
            throw new Bitrix24Exception('tag is null');
        }
        $fullResult = $this->client->call(
            'im.notify.delete',
            array(
                'tag' => (string)$tag
            )
        );
        return $fullResult;
    }

    /**
     * @param $subTag
     * @return array
     * @throws Bitrix24Exception
     * @throws \Bitrix24\Bitrix24SecurityException
     * @throws \Bitrix24\Bitrix24Exception
     * @throws \Bitrix24\Bitrix24ApiException
     * @throws \Bitrix24\Bitrix24TokenIsInvalid
     * @throws \Bitrix24\Bitrix24TokenIsExpired
     * @throws \Bitrix24\Bitrix24WrongClientException
     * @throws \Bitrix24\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Bitrix24SecurityException
     */
    public function deleteBySubTag($subTag)
    {
        if (null === $subTag) {
            throw new Bitrix24Exception('subTag is null');
        }
        $fullResult = $this->client->call(
            'im.notify.delete',
            array(
                'sub_tag' => (string)$subTag
            )
        );
        return $fullResult;
    }
}