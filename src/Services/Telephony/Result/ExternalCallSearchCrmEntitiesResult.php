<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Result;

use  Bitrix24\SDK\Core\Result\AbstractResult;

class ExternalCallSearchCrmEntitiesResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalCallSearchCrmEntitiesItemResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getCrmEntitiesClient(): ExternalCallSearchCrmEntitiesItemResult
    {
        return new ExternalCallSearchCrmEntitiesItemResult($this->getCoreResponse()->getResponseData()->getResult()->getResultData());
    }
}