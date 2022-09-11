<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\IMOpenLines\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\IMOpenLines\Result\AddedMessageItemResult;
use Bitrix24\SDK\Services\IMOpenLines\Result\JoinOpenLineResult;

class Network extends AbstractService
{
    /**
     * Connecting an open channel by code
     *
     * @param string $openLineCode
     *
     * @return \Bitrix24\SDK\Services\IMOpenLines\Result\JoinOpenLineResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/support/training/course/?COURSE_ID=115&LESSON_ID=25016
     */
    public function join(string $openLineCode): JoinOpenLineResult
    {
        return new JoinOpenLineResult(
            $this->core->call(
                'imopenlines.network.join',
                [
                    'CODE' => $openLineCode,
                ]
            )
        );
    }

    /**
     * Sending Open Channel message to selected user
     *
     * @param string     $openLineCode
     * @param int        $recipientUserId
     * @param string     $message
     * @param bool       $isMakeUrlPreview
     * @param array|null $attach
     * @param array|null $keyboard
     *
     * @return AddedMessageItemResult
     * @link https://training.bitrix24.com/support/training/course/?COURSE_ID=115&LESSON_ID=25018&LESSON_PATH=9691.9833.20331.25014.25018
     *
     */
    public function messageAdd(
        string $openLineCode,
        int $recipientUserId,
        string $message,
        bool $isMakeUrlPreview = true,
        ?array $attach = null,
        ?array $keyboard = null
    ): AddedMessageItemResult {
        return new AddedMessageItemResult(
            $this->core->call(
                'imopenlines.network.message.add',
                [
                    'CODE'        => $openLineCode,
                    'USER_ID'     => $recipientUserId,
                    'MESSAGE'     => $message,
                    'URL_PREVIEW' => $isMakeUrlPreview ? 'Y' : 'N',
                    'ATTACH'      => $attach,
                    'KEYBOARD'    => $keyboard,
                ]
            )
        );
    }
}