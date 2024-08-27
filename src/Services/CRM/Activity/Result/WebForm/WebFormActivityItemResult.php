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

namespace Bitrix24\SDK\Services\CRM\Activity\Result\WebForm;

use Bitrix24\SDK\Services\CRM\Activity\Result\ActivityItemResult;

class WebFormActivityItemResult extends ActivityItemResult
{
    /**
     * @return \Bitrix24\SDK\Services\CRM\Activity\Result\WebForm\WebFormProviderParams
     */
    public function getProviderParams(): WebFormProviderParams
    {
        return new WebFormProviderParams(
            $this->PROVIDER_PARAMS['FIELDS'],
            new WebFormMetadata(
                $this->PROVIDER_PARAMS['FORM']['IS_USED_USER_CONSENT'],
                $this->PROVIDER_PARAMS['FORM']['AGREEMENTS'],
                $this->PROVIDER_PARAMS['FORM']['IP'],
                $this->PROVIDER_PARAMS['FORM']['LINK']
            ),
            $this->PROVIDER_PARAMS['VISITED_PAGES'],
        );
    }
}