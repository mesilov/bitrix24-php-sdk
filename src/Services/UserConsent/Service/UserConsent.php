<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\UserConsent\Service;

use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Services\AbstractService;

class UserConsent extends AbstractService
{
    /**
     * Add the received user agreement consent
     *
     * @see https://training.bitrix24.com/rest_help/userconsent/userconsent_consent_add.php
     *
     * @param array $consentFields
     *
     * @return AddedItemResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function add(array $consentFields): AddedItemResult
    {
        return new AddedItemResult($this->core->call('userconsent.consent.add', $consentFields));
    }
}