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