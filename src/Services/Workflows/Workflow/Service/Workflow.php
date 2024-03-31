<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Workflow\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Psr\Log\LoggerInterface;


class Workflow extends AbstractService
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
     * returns list of launched workflows
     *
     * @param array $select
     * @param array $order
     * @param array $filter
     * @return Workflows\Workflow\Result\WorkflowInstancesResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_instances.php
     */
    public function instances(
        array $select = ['ID', 'MODIFIED', 'OWNED_UNTIL', 'MODULE_ID', 'ENTITY', 'DOCUMENT_ID', 'STARTED', 'STARTED_BY', 'TEMPLATE_ID'],
        array $order = ['STARTED' => 'DESC'],
        array $filter = []): Workflows\Workflow\Result\WorkflowInstancesResult
    {
        return new Workflows\Workflow\Result\WorkflowInstancesResult(
            $this->core->call(
                'bizproc.workflow.instances',
                [
                    'select' => $select,
                    'order' => $order,
                    'filter' => $filter,
                ]
            )
        );
    }
}