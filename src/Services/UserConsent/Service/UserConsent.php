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

namespace Bitrix24\SDK\Services\UserConsent\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Services\AbstractService;
#[ApiServiceMetadata(new Scope(['userconsent']))]
class UserConsent extends AbstractService
{
    /**
     * Add the received user agreement consent
     *
     * @see https://training.bitrix24.com/rest_help/userconsent/userconsent_consent_add.php
     *
     *
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'userconsent.consent.add',
        'https://training.bitrix24.com/rest_help/userconsent/userconsent_consent_add.php',
        'Add the received user agreement consent'
    )]
    public function add(array $consentFields): AddedItemResult
    {
        return new AddedItemResult($this->core->call('userconsent.consent.add', $consentFields));
    }
}