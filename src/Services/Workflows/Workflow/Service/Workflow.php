<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Workflow\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
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
     * bizproc.workflow.start launches a worfklow
     *
     * @throws TransportException
     * @throws InvalidArgumentException
     * @throws BaseException
     * @see https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_start.php
     *
     */
    public function start(
        Workflows\Common\WorkflowDocumentType $workflowDocumentType,
        int                                   $bizProcTemplateId,
        int                                   $entityId,
        array                                 $callParameters = [],
        int                                   $smartProcessId = null
    ): Workflows\Workflow\Result\WorkflowInstanceStartResult
    {
        $documentId = null;
        switch ($workflowDocumentType) {
            case Workflows\Common\WorkflowDocumentType::crmLead:
                $documentId = ['crm', $workflowDocumentType->value, sprintf('LEAD_%s', $entityId)];
                break;
            case Workflows\Common\WorkflowDocumentType::crmCompany:
                $documentId = ['crm', $workflowDocumentType->value, sprintf('COMPANY_%s', $entityId)];
                break;
            case Workflows\Common\WorkflowDocumentType::crmContact:
                $documentId = ['crm', $workflowDocumentType->value, sprintf('CONTACT_%s', $entityId)];
                break;
            case Workflows\Common\WorkflowDocumentType::crmDeal:
                $documentId = ['crm', $workflowDocumentType->value, sprintf('DEAL_%s', $entityId)];
                break;
            case Workflows\Common\WorkflowDocumentType::discBizProcDocument:
                $documentId = ['disk', $workflowDocumentType->value, $entityId];
                break;
            case Workflows\Common\WorkflowDocumentType::listBizProcDocumentLists:
            case Workflows\Common\WorkflowDocumentType::listBizProcDocument:
                $documentId = ['lists', $workflowDocumentType->value, $entityId];
                break;
            case Workflows\Common\WorkflowDocumentType::smartProcessDynamic:
                if ($smartProcessId === null) {
                    throw new InvalidArgumentException('smartProcessId not set');
                }
                $documentId = ['crm', $workflowDocumentType->value, sprintf('DYNAMIC_%s_%s', $smartProcessId, $entityId)];
                break;
            case Workflows\Common\WorkflowDocumentType::task:
                $documentId = ['tasks', $workflowDocumentType->value, $entityId];
                break;
            case Workflows\Common\WorkflowDocumentType::invoice:
                $documentId = ['tasks', $workflowDocumentType->value, sprintf('SMART_INVOICE_%s', $entityId)];
                break;
        }

        return new Workflows\Workflow\Result\WorkflowInstanceStartResult($this->core->call(
            'bizproc.workflow.start',
            [
                'TEMPLATE_ID' => $bizProcTemplateId,
                'DOCUMENT_ID' => $documentId,
                'PARAMETERS' => $callParameters
            ]
        ));

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