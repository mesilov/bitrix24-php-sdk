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

namespace Bitrix24\SDK\Services\Workflows\Task\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows\Common\DocumentType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskActivityType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskCompleteStatusType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskStatusType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskUserStatusType;
use Bitrix24\SDK\Services\Workflows\Task\Result\WorkflowTaskCompleteResult;
use Carbon\CarbonImmutable;
use Psr\Log\LoggerInterface;
use Bitrix24\SDK\Services\Workflows\Task\Result\WorkflowTasksResult;
#[ApiServiceMetadata(new Scope(['bizproc']))]
class Task extends AbstractService
{
    public function __construct(
        public Batch           $batch,
        CoreInterface   $core,
        LoggerInterface $log
    )
    {
        parent::__construct($core, $log);
    }

    /**
     * Complete workflow task
     *
     * Presently, the tasks Document approval and Document review can be executed.
     * Only your own task can be completed, as well as the task, not completed yet.
     *
     * Starting from the Business Process module version 20.0.800 you have an option to execute Request for extra information.
     * You can execute only your task and only when it wasn't executed yet.
     *
     * @return WorkflowTaskCompleteResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/workflows_tasks/bizproc_task_complete.php
     */
    #[ApiEndpointMetadata(
        'bizproc.task.complete',
        'https://training.bitrix24.com/rest_help/workflows/workflows_tasks/bizproc_task_complete.php',
        'Complete workflow task'
    )]
    public function complete(int $taskId, WorkflowTaskCompleteStatusType $status, string $comment, ?array $taskFields = null): WorkflowTaskCompleteResult
    {
        return new WorkflowTaskCompleteResult($this->core->call('bizproc.task.complete', [
            'TASK_ID' => $taskId,
            'STATUS' => $status->value,
            'COMMENT' => $comment,
            'FIELDS' => $taskFields
        ]));
    }

    /**
     * List of workflow tasks
     *
     * Not only administrators can access this method. Usual user can request his/her own tasks or tasks of his/her subordinate.
     * To request personal tasks, non-administrator should not specify filter for USER_ID
     *
     * @param array|array{
     *     ID?:int,
     *     WORKFLOW_ID?:string,
     *     DOCUMENT_NAME?:string,
     *     DESCRIPTION?:string,
     *     NAME?:string,
     *     MODIFIED?: CarbonImmutable,
     *     WORKFLOW_STARTED?: CarbonImmutable,
     *     WORKFLOW_STARTED_BY?: int,
     *     OVERDUE_DATE?: CarbonImmutable,
     *     WORKFLOW_TEMPLATE_ID?:int,
     *     WORKFLOW_TEMPLATE_NAME?:string,
     *     WORKFLOW_STATE?: string,
     *     STATUS?:WorkflowTaskStatusType,
     *     USER_ID?:int,
     *     USER_STATUS?:WorkflowTaskUserStatusType,
     *     MODULE_ID?:string,
     *     ENTITY?:DocumentType,
     *     DOCUMENT_ID?:int,
     *     ACTIVITY: WorkflowTaskActivityType,
     *     PARAMETERS?:array,
     *     DOCUMENT_URL?:string } $filter
     * @param array|array{
     *     'ID',
     *     'WORKFLOW_ID',
     *     'DOCUMENT_NAME',
     *     'NAME',
     *     'DESCRIPTION',
     *     'MODIFIED',
     *     'WORKFLOW_STARTED',
     *     'WORKFLOW_STARTED_BY',
     *     'OVERDUE_DATE',
     *     'WORKFLOW_TEMPLATE_ID',
     *     'WORKFLOW_TEMPLATE_NAME',
     *     'WORKFLOW_STATE',
     *     'STATUS',
     *     'USER_ID',
     *     'USER_STATUS',
     *     'MODULE_ID',
     *     'ENTITY',
     *     'DOCUMENT_ID',
     *     'ACTIVITY',
     *     'PARAMETERS',
     *     'DOCUMENT_URL' } $select
     * @return WorkflowTasksResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/workflows_tasks/bizproc_task_list.php
     */
    #[ApiEndpointMetadata(
        'bizproc.task.list',
        'https://training.bitrix24.com/rest_help/workflows/workflows_tasks/bizproc_task_list.php',
        'List of workflow tasks'
    )]
    public function list(
        array $order = ['ID' => 'DESC'],
        array $filter = [],
        array $select = ['ID', 'WORKFLOW_ID', 'DOCUMENT_NAME', 'NAME']): WorkflowTasksResult
    {
        return new WorkflowTasksResult($this->core->call('bizproc.task.list', [
            'SELECT' => $select,
            'FILTER' => $filter,
            'ORDER' => $order
        ]));
    }
}