<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Settings\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Settings\Result\SettingsModeResult;

/**
 * Class Settings
 *
 * @package Bitrix24\SDK\Services\CRM\Settings\Service
 */
class Settings extends AbstractService
{
    /**
     * @return SettingsModeResult
     * @throws BaseException
     * @throws TransportException
     */
    public function modeGet(): SettingsModeResult
    {
        return new SettingsModeResult($this->core->call('crm.settings.mode.get'));
    }
}