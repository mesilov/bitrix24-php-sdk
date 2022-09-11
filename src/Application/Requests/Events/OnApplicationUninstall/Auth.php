<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events\OnApplicationUninstall;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $domain
 * @property-read string $client_endpoint
 * @property-read string $server_endpoint
 * @property-read string $member_id
 * @property-read string $application_token
 */
class Auth extends AbstractItem
{
}