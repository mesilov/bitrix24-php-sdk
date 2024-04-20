<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Robot\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Bitrix24\SDK\Services\Workflows\Robot\Result\AddedRobotResult;
use Bitrix24\SDK\Services\Workflows\Robot\Result\UpdateRobotResult;
use Bitrix24\SDK\Services\Workflows\Template\Service\Batch;
use Psr\Log\LoggerInterface;


class Robot extends AbstractService
{
    public Batch $batch;

    public function __construct(
        Batch           $batch,
        CoreInterface   $core,
        LoggerInterface $log
    )
    {
        parent::__construct($core, $log);
        $this->batch = $batch;
    }

    /**
     * Registers new automation rule.
     *
     * @param string $code
     * @param string $handlerUrl
     * @param int $b24AuthUserId
     * @param array $localizedRobotName
     * @param bool $isUseSubscription
     * @param array $properties
     * @param bool $isUsePlacement
     * @param array $returnProperties
     *
     * @return AddedRobotResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/app_automation_rules/bizproc_robot_add.php
     */
    public function add(
        string $code,
        string $handlerUrl,
        int    $b24AuthUserId,
        array  $localizedRobotName,
        bool   $isUseSubscription,
        array  $properties,
        bool   $isUsePlacement,
        array  $returnProperties
    ): Workflows\Robot\Result\AddedRobotResult
    {
        return new Workflows\Robot\Result\AddedRobotResult($this->core->call('bizproc.robot.add', [
            'CODE' => $code,
            'HANDLER' => $handlerUrl,
            'AUTH_USER_ID' => $b24AuthUserId,
            'NAME' => $localizedRobotName,
            'USE_SUBSCRIPTION' => $isUseSubscription ? 'Y' : 'N',
            'PROPERTIES' => $properties,
            'USE_PLACEMENT' => $isUsePlacement ? 'Y' : 'N',
            'RETURN_PROPERTIES' => $returnProperties
        ]));
    }

    /**
     * This method returns list of automation rules, registered by the application.
     *
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/app_automation_rules/bizproc_robot_list.php
     */
    public function list(): Workflows\Robot\Result\WorkflowRobotsResult
    {
        return new Workflows\Robot\Result\WorkflowRobotsResult($this->core->call('bizproc.robot.list'));
    }

    /**
     * This method deletes registered automation rule.
     *
     * @param string $robotCode
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/app_automation_rules/bizproc_robot_delete.php
     */
    public function delete(string $robotCode): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call('bizproc.robot.delete', [
                'CODE' => $robotCode
            ]));
    }

    /**
     * updates fields of automation rules
     *
     * @param string $code
     * @param string|null $handlerUrl
     * @param int|null $b24AuthUserId
     * @param array|null $localizedRobotName
     * @param bool $isUseSubscription
     * @param array|null $properties
     * @param bool $isUsePlacement
     * @param array|null $returnProperties
     * @return UpdateRobotResult
     * @throws BaseException
     * @throws TransportException
     * @see  https://training.bitrix24.com/rest_help/workflows/app_automation_rules/bizproc_robot_update.php
     */
    public function update(
        string  $code,
        ?string $handlerUrl = null,
        ?int    $b24AuthUserId = null,
        ?array  $localizedRobotName = null,
        ?bool   $isUseSubscription = null,
        ?array  $properties = null,
        ?bool   $isUsePlacement = null,
        ?array  $returnProperties = null
    ): Workflows\Robot\Result\UpdateRobotResult
    {
        $fieldsToUpdate = [];
        if ($handlerUrl !== null) {
            $fieldsToUpdate['HANDLER'] = $handlerUrl;
        }
        if ($b24AuthUserId !== null) {
            $fieldsToUpdate['AUTH_USER_ID'] = $b24AuthUserId;
        }
        if ($localizedRobotName !== null) {
            $fieldsToUpdate['NAME'] = $localizedRobotName;
        }
        if ($isUseSubscription !== null) {
            $fieldsToUpdate['USE_SUBSCRIPTION'] = $isUseSubscription ? 'Y' : 'N';
        }
        if ($properties !== null) {
            $fieldsToUpdate['PROPERTIES'] = $properties;
        }
        if ($isUsePlacement !== null) {
            $fieldsToUpdate['USE_PLACEMENT'] = $isUsePlacement ? 'Y' : 'N';
        }
        if ($returnProperties !== null) {
            $fieldsToUpdate['RETURN_PROPERTIES'] = $returnProperties;
        }

        return new Workflows\Robot\Result\UpdateRobotResult($this->core->call(
            'bizproc.robot.update',
            [
                'CODE' => $code,
                'FIELDS' => $fieldsToUpdate
            ]));
    }
}