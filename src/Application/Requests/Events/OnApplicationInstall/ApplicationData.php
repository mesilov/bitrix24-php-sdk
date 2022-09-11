<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events\OnApplicationInstall;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $VERSION
 * @property-read string $ACTIVE
 * @property-read string $INSTALLED
 * @property-read string $LANGUAGE_ID
 */
class ApplicationData extends AbstractItem
{
}