<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Template\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Infrastructure\Filesystem\Base64Encoder;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Psr\Log\LoggerInterface;


class Template extends AbstractService
{
    public Batch $batch;
    private Base64Encoder $base64Encoder;

    public function __construct(
        Batch           $batch,
        CoreInterface   $core,
        Base64Encoder   $base64Encoder,
        LoggerInterface $log
    )
    {
        parent::__construct($core, $log);
        $this->batch = $batch;
        $this->base64Encoder = $base64Encoder;
    }

    /**
     * Add a workflow template, requires administrator access permissions
     *
     * @param Workflows\Common\WorkflowDocumentType $workflowDocumentType
     * @param string $name
     * @param string $description
     * @param Workflows\Common\WorkflowAutoExecutionType $workflowAutoExecutionType
     * @param string $filename
     * @return AddedItemResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_add.php
     */
    public function add(
        Workflows\Common\WorkflowDocumentType      $workflowDocumentType,
        string                                     $name,
        string                                     $description,
        Workflows\Common\WorkflowAutoExecutionType $workflowAutoExecutionType,
        string                                     $filename
    ): AddedItemResult
    {
        return new AddedItemResult($this->core->call('bizproc.workflow.template.add', [
            'DOCUMENT_TYPE' => $workflowDocumentType->toArray(),
            'NAME' => $name,
            'DESCRIPTION' => $description,
            'AUTO_EXECUTE' => (string)$workflowAutoExecutionType->value,
            'TEMPLATE_DATA' => $this->base64Encoder->encodeFile($filename)
        ]));
    }

    /**
     * The method deletes workflow template. Requires the administrator access permissions.
     *
     * This method deletes only the templates created via the method bizproc.workflow.template.add,
     * because such templates are bound to an app and only they can be deleted.
     *
     * @param int $templateId
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_delete.php
     */
    public function delete(int $templateId): DeletedItemResult
    {
        return new DeletedItemResult($this->core->call('bizproc.workflow.template.delete', [
            'ID' => $templateId
        ]));
    }

    /**
     * The method bizproc.workflow.template.list returns list of workflow templates, specified for a site. This method requires administrator access permissions.
     * @param array $select
     * @param array $filter
     * @return Workflows\Template\Result\WorkflowTemplatesResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_list.php
     */
    public function list(
        array $select = ['ID', 'MODULE_ID', 'ENTITY', 'DOCUMENT_TYPE', 'AUTO_EXECUTE', 'NAME', 'NAME', 'TEMPLATE', 'PARAMETERS', 'VARIABLES', 'CONSTANTS', 'MODIFIED', 'IS_MODIFIED', 'USER_ID', 'SYSTEM_CODE'],
        array $filter = []): Workflows\Template\Result\WorkflowTemplatesResult
    {
        return new Workflows\Template\Result\WorkflowTemplatesResult(
            $this->core->call(
                'bizproc.workflow.template.list',
                [
                    'select' => $select,
                    'filter' => $filter,
                ]
            )
        );
    }
}