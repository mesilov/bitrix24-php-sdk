<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Events\OnApplicationInstall;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $access_token
 * @property-read string $expires
 * @property-read string $expires_in
 * @property-read string $scope
 * @property-read string $domain
 * @property-read string $server_endpoint
 * @property-read string $status
 * @property-read string $client_endpoint
 * @property-read string $member_id
 * @property-read string $user_id
 * @property-read string $refresh_token
 * @property-read string $application_token
 */
class Auth extends AbstractItem
{
}