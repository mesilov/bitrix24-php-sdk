<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Template\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Core\Result\AbstractResult;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealItemResult;
use DateTimeInterface;

class WorkflowTemplatesResult extends AbstractResult
{
    /**
     * @return WorkflowTemplateItemResult[]
     * @throws BaseException
     */
    public function getTemplates(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new WorkflowTemplateItemResult($item);
        }

        return $res;
    }
}