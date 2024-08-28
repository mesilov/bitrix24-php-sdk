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

namespace Bitrix24\SDK\Services\Workflows\Workflow\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Psr\Log\LoggerInterface;
#[ApiServiceMetadata(new Scope(['bizproc']))]
class Workflow extends AbstractService
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
     * Deletes a launched workflow
     *
     * @param non-empty-string $workflowId Workflow id
     * @return Workflows\Workflow\Result\WorkflowKillResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_kill.php
     */
    #[ApiEndpointMetadata(
        'bizproc.workflow.kill',
        'https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_kill.php',
        'Deletes a launched workflow'
    )]
    public function kill(string $workflowId): Workflows\Workflow\Result\WorkflowKillResult
    {
        return new Workflows\Workflow\Result\WorkflowKillResult($this->core->call('bizproc.workflow.kill', [
            'ID' => $workflowId,
        ]));
    }

    /**
     * Stops an active workflow.
     *
     * @return Workflows\Workflow\Result\WorkflowTerminationResult
     * @see https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_terminate.php
     */
    #[ApiEndpointMetadata(
        'bizproc.workflow.terminate',
        'https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_terminate.php',
        'Stops an active workflow.'
    )]
    public function terminate(string $workflowId, string $message): Workflows\Workflow\Result\WorkflowTerminationResult
    {
        return new Workflows\Workflow\Result\WorkflowTerminationResult($this->core->call('bizproc.workflow.terminate', [
            'ID' => $workflowId,
            'STATUE' => $message
        ]));
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
    #[ApiEndpointMetadata(
        'bizproc.workflow.start',
        'https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_start.php',
        'Launches a workflow'
    )]
    public function start(
        Workflows\Common\DocumentType $workflowDocumentType,
        int                           $bizProcTemplateId,
        int                           $entityId,
        array                         $callParameters = [],
        int                           $smartProcessId = null
    ): Workflows\Workflow\Result\WorkflowInstanceStartResult
    {
        $documentId = null;
        switch ($workflowDocumentType) {
            case Workflows\Common\DocumentType::crmLead:
                $documentId = ['crm', $workflowDocumentType->value, sprintf('LEAD_%s', $entityId)];
                break;
            case Workflows\Common\DocumentType::crmCompany:
                $documentId = ['crm', $workflowDocumentType->value, sprintf('COMPANY_%s', $entityId)];
                break;
            case Workflows\Common\DocumentType::crmContact:
                $documentId = ['crm', $workflowDocumentType->value, sprintf('CONTACT_%s', $entityId)];
                break;
            case Workflows\Common\DocumentType::crmDeal:
                $documentId = ['crm', $workflowDocumentType->value, sprintf('DEAL_%s', $entityId)];
                break;
            case Workflows\Common\DocumentType::discBizProcDocument:
                $documentId = ['disk', $workflowDocumentType->value, $entityId];
                break;
            case Workflows\Common\DocumentType::listBizProcDocumentLists:
            case Workflows\Common\DocumentType::listBizProcDocument:
                $documentId = ['lists', $workflowDocumentType->value, $entityId];
                break;
            case Workflows\Common\DocumentType::smartProcessDynamic:
                if ($smartProcessId === null) {
                    throw new InvalidArgumentException('smartProcessId not set');
                }
                $documentId = ['crm', $workflowDocumentType->value, sprintf('DYNAMIC_%s_%s', $smartProcessId, $entityId)];
                break;
            case Workflows\Common\DocumentType::task:
                $documentId = ['tasks', $workflowDocumentType->value, $entityId];
                break;
            case Workflows\Common\DocumentType::invoice:
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
     * @return Workflows\Workflow\Result\WorkflowInstancesResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_instances.php
     */
    #[ApiEndpointMetadata(
        'bizproc.workflow.instances',
        'https://training.bitrix24.com/rest_help/workflows/workflow/bizproc_workflow_instances.php',
        'returns list of launched workflows'
    )]
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