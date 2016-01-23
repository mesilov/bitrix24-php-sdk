<?php

namespace Bitrix24\Im;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Presets\Im\Fields as B24ImFields;

/**
 * Class Im.
 */
class im extends Bitrix24Entity
{
    /**
     * send notification to user.
     *
     * @link https://training.bitrix24.com/rest_help/im/im_notify.php
     *
     * @param $userId integer bitrix24 user identifier
     * @param $message string message to user, support some html tags
     * @param $notifyType string
     *  - SYSTEM send message from current application
     *  - USER send message from current user, default value
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function notify($userId, $message, $notifyType = B24ImFields::NOTIFY_TYPE_USER)
    {
        if (is_null($userId)) {
            throw new Bitrix24Exception('user id is null');
        } elseif (is_null($message)) {
            throw new Bitrix24Exception('message is null');
        } elseif (!in_array(strtoupper($notifyType), [B24ImFields::NOTIFY_TYPE_SYSTEM, B24ImFields::NOTIFY_TYPE_USER], true)) {
            throw new Bitrix24Exception('unknown notifyType');
        }
        $fullResult = $this->client->call(
            'im.notify',
            [
                'to'      => $userId,
                'message' => $message,
                'type'    => strtoupper($notifyType),
            ]
        );

        return $fullResult;
    }
}
