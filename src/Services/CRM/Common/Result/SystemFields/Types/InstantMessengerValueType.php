<?php

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