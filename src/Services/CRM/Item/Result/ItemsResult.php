<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Item\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ItemsResult extends AbstractResult
{
    /**
     * @return ItemItemResult[]
     * @throws BaseException
     */
    public function getItems(): array
    {
        $items = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $items[] = new ItemItemResult($item);
        }

        return $items;
    }
}