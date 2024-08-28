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

namespace Bitrix24\SDK\Services\Telephony\Voximplant\Url\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Voximplant\Url\Result\VoximplantPagesResult;
use Psr\Log\LoggerInterface;
#[ApiServiceMetadata(new Scope(['telephony']))]
class Url extends AbstractService
{
    public function __construct(
        readonly public Batch $batch,
        CoreInterface         $core,
        LoggerInterface       $logger
    )
    {
        parent::__construct($core, $logger);
    }

    /**
     * Returns a set of links for browsing telephony scope pages.
     *
     * This method does not have limitations of access permissions.
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_url_get.php
     */
    #[ApiEndpointMetadata(
        'voximplant.url.get',
        'https://training.bitrix24.com/rest_help/scope_telephony/voximplant/voximplant_url_get.php',
        'Returns a set of links for browsing telephony scope pages.'
    )]
    public function get(): VoximplantPagesResult
    {
        return new VoximplantPagesResult($this->core->call('voximplant.url.get'));
    }
}