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

namespace Bitrix24\SDK\Services\Telephony\ExternalLine\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\EmptyResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Result\ExternalLineAddedResult;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Result\ExternalLinesResult;
use Psr\Log\LoggerInterface;
#[ApiServiceMetadata(new Scope(['telephony']))]
class ExternalLine extends AbstractService
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
     * Method adds an external line
     *
     * @param non-empty-string $lineNumber Number of the external line (For example: 8-9938-832799312)
     * @param bool $isAutoCreateCrmEntities This parameter is responsible for creating CRM entities (deal or lead, depending on the CRM mode)
     * for outbound calls from Bitrix24 interface (for example, dialer in chat panel). Default value is true
     * @param non-empty-string|null $lineName Name of the external line. Optional.
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_add.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalLine.add',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_add.php',
        'Method adds an external line'
    )]
    public function add(string $lineNumber, bool $isAutoCreateCrmEntities = true, ?string $lineName = null): ExternalLineAddedResult
    {
        return new ExternalLineAddedResult($this->core->call('telephony.externalLine.add', [
            'NUMBER' => $lineNumber,
            'NAME' => $lineName,
            'CRM_AUTO_CREATE' => $isAutoCreateCrmEntities ? 'Y' : 'N'
        ]));
    }

    /**
     * Method for deleting an external line.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_delete.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalLine.delete',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_delete.php',
        'Method for deleting an external line.'
    )]
    public function delete(string $lineNumber): EmptyResult
    {
        return new EmptyResult($this->core->call('telephony.externalLine.delete', [
            'NUMBER' => $lineNumber
        ]));
    }

    /**
     * Method allows to retrieve the list of external lines of an application.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_get.php
     */
    #[ApiEndpointMetadata(
        'telephony.externalLine.get',
        'https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_delete.php',
        'Method allows to retrieve the list of external lines of an application.'
    )]
    public function get(): ExternalLinesResult
    {
        return new ExternalLinesResult($this->core->call('telephony.externalLine.get'));
    }
}