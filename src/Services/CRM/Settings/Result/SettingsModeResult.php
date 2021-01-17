<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Settings\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class SettingsModeResult
 *
 * @package Bitrix24\SDK\Services\CRM\Settings\Result
 */
class SettingsModeResult extends AbstractResult
{
    public function getModeId(): int
    {
        return $this->getCoreResponse()->getResponseData()->getResult()->getResultData()[0];
    }
}