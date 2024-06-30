<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Url\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class VoximplantPagesResult extends AbstractResult
{
    public function getPages(): VoximplantPagesItemResult
    {
        return new VoximplantPagesItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}