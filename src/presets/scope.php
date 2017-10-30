<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\Presets;

/**
 * Class Scope
 * @package Bitrix24\Presets
 */
class Scope
{
    /**
     * @var string work with business process
     */
    const BIZPROC = 'bizproc';

    /**
     * @var string work with calendar
     */
    const CALENDAR = 'calendar';

    /**
     * @var string work with CRM
     */
    const CRM = 'crm';

    /**
     * @var string work with bitrix24 disk
     */
    const DISK = 'disk';

    /**
     * @var string work with departments
     */
    const DEPARTMENT = 'department';

    /**
     * @var string work with B24 entity
     */
    const ENTITY = 'entity';

    /**
     * @var string work with IM
     */
    const IM = 'im';

    /**
     * @var string work with IM bot
     */
    const IMBOT = 'imbot';

    /**
     * @var string work with users
     */
    const USER = 'user';

    /**
     * @var string work with mail
     */
    const MAILSERVICE = 'mailservice';

    /**
     * @var string work with task
     */
    const TASK = 'task';

    /**
     * @var string work with task extended
     */
    const TASKS_EXTENDED = 'tasks_extended';

    /**
     * @var string work with telephony
     */
    const TELEPHONY = 'telephony';

    /**
     * @var string work with life line
     */
    const LOG = 'log';

    /**
     * @var string work with sonet group
     */
    const SONET_GROUP = 'sonet_group';

    /**
     * @var string work with lists
     */
    const LISTS = 'lists';

    /**
     * @var string work with placement
     */
    const PLACEMENT = 'placement';
}