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

namespace Bitrix24\SDK\Services\IM\Notify\Service;


use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;

#[ApiServiceMetadata(new Scope(['im']))]
class Notify extends AbstractService
{
    /**
     * @param positive-int $userId
     * @param non-empty-string $message
     * @param non-empty-string|null $forEmailChannelMessage
     * @param non-empty-string|null $notificationTag
     * @param non-empty-string|null $subTag
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'im.notify.system.add',
        'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=115&LESSON_ID=23904&LESSON_PATH=9691.9805.11585.23904',
        'Sending system notification'
    )]
    public function fromSystem(
        int     $userId,
        string  $message,
        ?string $forEmailChannelMessage = null,
        ?string $notificationTag = null,
        ?string $subTag = null,
        ?array  $attachment = null
    ): AddedItemResult
    {
        return new AddedItemResult($this->core->call(
            'im.notify.system.add',
            [
                'USER_ID' => $userId,
                'MESSAGE' => $message,
                'MESSAGE_OUT' => $forEmailChannelMessage,
                'TAG' => $notificationTag,
                'SUB_TAG' => $subTag,
                'ATTACH' => $attachment,
            ]
        ));
    }

    #[ApiEndpointMetadata(
        'im.notify.personal.add',
        'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=115&LESSON_ID=23904&LESSON_PATH=9691.9805.11585.23904',
        'Sending personal notification'
    )]
    public function fromPersonal(
        int     $userId,
        string  $message,
        ?string $forEmailChannelMessage = null,
        ?string $notificationTag = null,
        ?string $subTag = null,
        ?array  $attachment = null
    ): AddedItemResult
    {
        return new AddedItemResult($this->core->call(
            'im.notify.personal.add',
            [
                'USER_ID' => $userId,
                'MESSAGE' => $message,
                'MESSAGE_OUT' => $forEmailChannelMessage,
                'TAG' => $notificationTag,
                'SUB_TAG' => $subTag,
                'ATTACH' => $attachment,
            ]
        ));
    }

    #[ApiEndpointMetadata(
        'im.notify.delete',
        'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=115&LESSON_ID=23906&LESSON_PATH=9691.9805.11585.23906',
        'Deleting notification'
    )]
    public function delete(
        int     $notificationId,
        ?string $notificationTag = null,
        ?string $subTag = null,
    ): DeletedItemResult
    {
        return new DeletedItemResult($this->core->call(
            'im.notify.delete',
            [
                'ID' => $notificationId,
                'TAG' => $notificationTag,
                'SUB_TAG' => $subTag
            ]
        ));
    }

    #[ApiEndpointMetadata(
        'im.notify.read',
        'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=115&LESSON_ID=11587&LESSON_PATH=9691.9805.11585.11587',
        'The method cancels notification for read messages.'
    )]
    public function markAsRead(
        int  $notificationId,
        bool $isOnlyCurrent = true,
    ): UpdatedItemResult
    {
        return new UpdatedItemResult($this->core->call(
            'im.notify.read',
            [
                'ID' => $notificationId,
                'ONLY_CURRENT' => $isOnlyCurrent ? 'Y' : 'N',
            ]
        ));
    }

    #[ApiEndpointMetadata(
        'im.notify.read',
        'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=115&LESSON_ID=23908&LESSON_PATH=9691.9805.11585.23908',
        '"Read" the list of notifications, excluding CONFIRM notification type'
    )]
    public function markMessagesAsRead(
        array $notificationIds
    ): UpdatedItemResult
    {
        return new UpdatedItemResult($this->core->call(
            'im.notify.read',
            [
                'IDS' => $notificationIds,
                'ACTION' => 'Y',
            ]
        ));
    }

    #[ApiEndpointMetadata(
        'im.notify.read',
        'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=115&LESSON_ID=23908&LESSON_PATH=9691.9805.11585.23908',
        '"Unread" the list of notifications, excluding CONFIRM notification type'
    )]
    public function markMessagesAsUnread(
        array $notificationIds
    ): UpdatedItemResult
    {
        return new UpdatedItemResult($this->core->call(
            'im.notify.read',
            [
                'IDS' => $notificationIds,
                'ACTION' => 'N',
            ]
        ));
    }

    #[ApiEndpointMetadata(
        'im.notify.confirm',
        'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=115&LESSON_ID=23912&LESSON_PATH=9691.9805.11585.23912',
        'Interaction with notification buttons'
    )]
    public function confirm(
        int  $notificationId,
        bool $isAccept
    ): UpdatedItemResult
    {
        return new UpdatedItemResult($this->core->call(
            'im.notify.confirm',
            [
                'ID' => $notificationId,
                'NOTIFY_VALUE' => $isAccept ? 'Y' : 'N',
            ]
        ));
    }

    #[ApiEndpointMetadata(
        'im.notify.answer',
        'https://training.bitrix24.com/support/training/course/index.php?COURSE_ID=115&LESSON_ID=23910&LESSON_PATH=9691.9805.11585.23910',
        'Response to notification, supporting quick reply'
    )]
    public function answer(
        int    $notificationId,
        string $answerText
    ): UpdatedItemResult
    {
        return new UpdatedItemResult($this->core->call(
            'im.notify.answer',
            [
                'ID' => $notificationId,
                'ANSWER_TEXT' => $answerText,
            ]
        ));
    }
}