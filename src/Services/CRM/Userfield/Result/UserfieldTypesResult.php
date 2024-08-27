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

namespace Bitrix24\SDK\Services\CRM\Userfield\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class UserfieldTypesResult extends AbstractResult
{
    /**
     * @return \Bitrix24\SDK\Services\CRM\Userfield\Result\UserfieldTypeItemResult[]
     * @throws BaseException
     */
    public function getTypes(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new UserfieldTypeItemResult($item);
        }

        return $res;
    }
}