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

namespace Bitrix24\SDK\Services\Workflows\Activity\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

class UpdateActivityResult extends AbstractResult
{
    public function isSuccess(): bool
    {
        return $this->getCoreResponse()->getResponseData()->getResult()[0];
    }
}