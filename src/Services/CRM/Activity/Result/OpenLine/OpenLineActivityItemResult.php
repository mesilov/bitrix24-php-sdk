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

namespace Bitrix24\SDK\Services\CRM\Activity\Result\OpenLine;

use Bitrix24\SDK\Services\CRM\Activity\Result\ActivityItemResult;

class OpenLineActivityItemResult extends ActivityItemResult
{
    /**
     * @return \Bitrix24\SDK\Services\CRM\Activity\Result\OpenLine\OpenLineProviderParams
     */
    public function getProviderParams(): OpenLineProviderParams
    {
        return new OpenLineProviderParams($this->PROVIDER_PARAMS['USER_CODE']);
    }
}