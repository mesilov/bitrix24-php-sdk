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

namespace Bitrix24\SDK\Services\Placement\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Placement\Result\PlacementBindResult;
use Bitrix24\SDK\Services\Placement\Result\PlacementLocationCodesResult;
use Bitrix24\SDK\Services\Placement\Result\PlacementsLocationInformationResult;
use Bitrix24\SDK\Services\Placement\Result\PlacementUnbindResult;
#[ApiServiceMetadata(new Scope(['placement']))]
class Placement extends AbstractService
{
    /**
     * Installs the embedding location handler
     *
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/metods/placement_bind.php
     */
    #[ApiEndpointMetadata(
        'placement.bind',
        'https://training.bitrix24.com/rest_help/application_embedding/metods/placement_bind.php',
        'Installs the embedding location handler'
    )]
    public function bind(string $placementCode, string $handlerUrl, array $lang): PlacementBindResult
    {
        return new PlacementBindResult(
            $this->core->call(
                'placement.bind',
                [
                    'PLACEMENT' => $placementCode,
                    'HANDLER'   => $handlerUrl,
                    'LANG_ALL'  => $lang,
                ]
            )
        );
    }

    /**
     * Deletes the registered embedding location handler. Shall be executed with the available account administrative privileges.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/metods/placement_unbind.php
     */
    #[ApiEndpointMetadata(
        'placement.unbind',
        'https://training.bitrix24.com/rest_help/application_embedding/metods/placement_unbind.php',
        'Deletes the registered embedding location handler. Shall be executed with the available account administrative privileges.'
    )]
    public function unbind(string $placementCode, ?string $handlerUrl = null): PlacementUnbindResult
    {
        return new PlacementUnbindResult(
            $this->core->call(
                'placement.unbind',
                [
                    'PLACEMENT' => $placementCode,
                    'HANDLER'   => $handlerUrl,
                ]
            )
        );
    }

    /**
     * This method is used to retrieve the list of embedding locations, available to the application.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/metods/placement_list.php
     */
    #[ApiEndpointMetadata(
        'placement.list',
        'https://training.bitrix24.com/rest_help/application_embedding/metods/placement_list.php',
        'This method is used to retrieve the list of embedding locations, available to the application.'
    )]
    public function list(?string $applicationScopeCode = null): PlacementLocationCodesResult
    {
        return new PlacementLocationCodesResult(
            $this->core->call('placement.list', [
                'SCOPE' => $applicationScopeCode,
            ])
        );
    }

    /**
     * This method is used to retrieve the list of registered handlers for embedding locations.
     *
     * @throws BaseException
     * @throws TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/metods/placement_get.php
     */
    #[ApiEndpointMetadata(
        'placement.get',
        'https://training.bitrix24.com/rest_help/application_embedding/metods/placement_get.php',
        'This method is used to retrieve the list of registered handlers for embedding locations.'
    )]
    public function get(): PlacementsLocationInformationResult
    {
        return new PlacementsLocationInformationResult($this->core->call('placement.get'));
    }
}