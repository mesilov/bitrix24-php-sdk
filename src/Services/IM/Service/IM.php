<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\IM\Service;


use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;

/**
 * Class IM
 *
 * @package Bitrix24\SDK\Services\IM\Service
 */
class IM extends AbstractService
{
    /**
     * @param int    $userId
     * @param string $message
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function notifyFromSystem(int $userId, string $message): Response
    {
        $this->log->debug(
            'notifyFromSystem.start',
            [
                'to'      => $userId,
                'message' => $message,
            ]
        );

        $result = $this->core->call(
            'im.notify',
            [
                'to'      => $userId,
                'message' => $message,
                'type'    => 'SYSTEM',
            ]
        );

        $this->log->debug('notifyFromSystem.finish');

        return $result;
    }

    /**
     * @param int    $userId
     * @param string $message
     *
     * @return Response
     * @throws BaseException
     * @throws TransportException
     */
    public function notifyFromUser(int $userId, string $message): Response
    {
        $this->log->debug(
            'notifyFromUser.start',
            [
                'to'      => $userId,
                'message' => $message,
            ]
        );

        $result = $this->core->call(
            'im.notify',
            [
                'to'      => $userId,
                'message' => $message,
                'type'    => 'USER',
            ]
        );

        $this->log->debug('notifyFromUser.finish');

        return $result;
    }
}