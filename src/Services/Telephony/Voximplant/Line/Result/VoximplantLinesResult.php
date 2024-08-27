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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Line\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Result\SipLineItemResult;

class VoximplantLinesResult extends AbstractResult
{
    /**
     * @return VoximplantLineItemResult[]
     * @throws BaseException
     */
    public function getLines(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $lineId => $line) {
            $res[] = new VoximplantLineItemResult([
                'LINE_ID' => $lineId,
                'NUMBER' => $line
            ]);
        }

        return $res;
    }
}