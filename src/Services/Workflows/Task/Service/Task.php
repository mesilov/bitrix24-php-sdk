<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Task\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows\Common\DocumentType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskActivityType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskStatusType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskUserStatusType;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Psr\Log\LoggerInterface;
use Bitrix24\SDK\Services\Workflows\Task\Result\WorkflowTasksResult;

class Task extends AbstractService
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
     * List of workflow tasks
     *
     * Not only administrators can access this method. Usual user can request his/her own tasks or tasks of his/her subordinate.
     * To request personal tasks, non-administrator should not specify filter for USER_ID
     *
     * @param array $order
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