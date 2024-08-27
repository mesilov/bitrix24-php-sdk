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

namespace Bitrix24\SDK\Services\CRM\Settings\Service;

use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Settings\Result\SettingsModeResult;
use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;

#[ApiServiceMetadata(new Scope(['crm']))]
class Settings extends AbstractService
{
    /**
     * @return SettingsModeResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.settings.mode.get',
        'https://training.bitrix24.com/rest_help/crm/mode/crm_settings_mode_get.php',
        'The method returns current settings for CRM mode'
    )]
    public function modeGet(): SettingsModeResult
    {
        return new SettingsModeResult($this->core->call('crm.settings.mode.get'));
    }
}