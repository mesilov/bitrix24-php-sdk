<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Services\IMOpenLines\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\IMOpenLines\Result\AddedMessageItemResult;
use Bitrix24\SDK\Services\IMOpenLines\Result\JoinOpenLineResult;

#[ApiServiceMetadata(new Scope(['imopenlines']))]
class Network extends AbstractService
{
    /**
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/support/training/course/?COURSE_ID=115&LESSON_ID=25016
     */
    #[ApiEndpointMetadata(
        'imopenlines.network.join',
        'https://training.bitrix24.com/support/training/course/?COURSE_ID=115&LESSON_ID=25016',
        'Connecting an open channel by code'
    )]
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
     * @link https://training.bitrix24.com/support/training/course/?COURSE_ID=115&LESSON_ID=25018&LESSON_PATH=9691.9833.20331.25014.25018
     */
    #[ApiEndpointMetadata(
        'imopenlines.network.message.add',
        'https://training.bitrix24.com/support/training/course/?COURSE_ID=115&LESSON_ID=25018&LESSON_PATH=9691.9833.20331.25014.25018',
        'Sending Open Channel message to selected user'
    )]
    public function messageAdd(
        string $openLineCode,
        int    $recipientUserId,
        string $message,
        bool   $isMakeUrlPreview = true,
        ?array $attach = null,
        ?array $keyboard = null
    ): AddedMessageItemResult
    {
        return new AddedMessageItemResult(
            $this->core->call(
                'imopenlines.network.message.add',
                [
                    'CODE' => $openLineCode,
                    'USER_ID' => $recipientUserId,
                    'MESSAGE' => $message,
                    'URL_PREVIEW' => $isMakeUrlPreview ? 'Y' : 'N',
                    'ATTACH' => $attach,
                    'KEYBOARD' => $keyboard,
                ]
            )
        );
    }
}