<?php
declare(strict_types=1);

/*
 * This file is part of the bitrix24-php-sdk package.
 *
 *  Kirill  Кhramov <k_hram@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Services\Telephony\Result;

use Bitrix24\SDK\Core\Contracts\AddedItemIdResultInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class CallAttachTranscriptionResult extends AbstractResult implements AddedItemIdResultInterface
{
    /**
     * @return int
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */

    public function getId():int
    {
        return $this->getCoreResponse()->getResponseData()->getResult()['TRANSCRIPT_ID'];
    }
}