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

namespace Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types;

enum InstantMessengerValueType: string
{
    case facebook = 'FACEBOOK';
    case telegram = 'TELEGRAM';
    case vk = 'VK';
    case skype = 'SKYPE';
    case viber = 'VIBER';
    case instagram = 'INSTAGRAM';
    case bitrix24 = 'BITRIX24';
    case openline = 'OPENLINE';
    case imol = 'IMOL';
    case icq = 'ICQ';
    case msn = 'MSN';
    case jabber = 'JABBER';
    case other = 'OTHER';
}