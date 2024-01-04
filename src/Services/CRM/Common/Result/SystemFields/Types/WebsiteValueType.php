<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types;

enum WebsiteValueType: string
{
    case work = 'WORK';
    case home = 'HOME';
    case facebook = 'FACEBOOK';
    case vk = 'VK';
    case livejournal = 'LIVEJOURNAL';
    case twitter = 'TWITTER';
    case other = 'OTHER';
}