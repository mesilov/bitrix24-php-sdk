<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Placement\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Placement\Result\PlacementBindResult;
use Bitrix24\SDK\Services\Placement\Result\PlacementLocationCodesResult;
use Bitrix24\SDK\Services\Placement\Result\PlacementsLocationInformationResult;
use Bitrix24\SDK\Services\Placement\Result\PlacementUnbindResult;

class Placement extends AbstractService
{
    /**
     * Installs the embedding location handler
     *
     * @param string $placementCode
     * @param string $handlerUrl
     * @param array  $lang
     *
     * @return \Bitrix24\SDK\Services\Placement\Result\PlacementBindResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/metods/placement_bind.php
     */
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
     * @param string $placementCode
     * @param string|null $handlerUrl
     *
     * @return \Bitrix24\SDK\Services\Placement\Result\PlacementUnbindResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/metods/placement_unbind.php
     */
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
     * @param string|null $applicationScopeCode
     *
     * @return PlacementLocationCodesResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/metods/placement_list.php
     */
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
     * @return PlacementsLocationInformationResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/application_embedding/metods/placement_get.php
     */
    public function get(): PlacementsLocationInformationResult
    {
        return new PlacementsLocationInformationResult($this->core->call('placement.get'));
    }
}