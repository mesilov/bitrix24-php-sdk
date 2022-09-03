<?php

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