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

namespace Bitrix24\SDK\Services\Workflows\Template\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\AddedItemResult;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Infrastructure\Filesystem\Base64Encoder;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Psr\Log\LoggerInterface;

#[ApiServiceMetadata(new Scope(['bizproc']))]
class Template extends AbstractService
{
    public function __construct(
        public Batch           $batch,
        CoreInterface   $core,
        private readonly Base64Encoder   $base64Encoder,
        LoggerInterface $log
    )
    {
        parent::__construct($core, $log);
    }

    /**
     * Add a workflow template, requires administrator access permissions
     *
     * @return AddedItemResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_add.php
     */
    #[ApiEndpointMetadata(
        'bizproc.workflow.template.add',
        'https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_add.php',
        'Add a workflow template, requires administrator access permissions'
    )]
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
     * Update workflow template
     *
     * Requires administrator access permissions. This method only updates the templates created via the method bizproc.workflow.template.add,
     * because such templates are bound to a specific app.
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\FileNotFoundException
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @see https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_update.php
     */
    #[ApiEndpointMetadata(
        'bizproc.workflow.template.update',
        'https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_update.php',
        'Update workflow template'
    )]
    public function update(
        int                                         $templateId,
        ?Workflows\Common\WorkflowDocumentType      $workflowDocumentType,
        ?string                                     $name,
        ?string                                     $description,
        ?Workflows\Common\WorkflowAutoExecutionType $workflowAutoExecutionType,
        ?string                                     $filename
    )
    {
        $fieldsToUpdate = [];
        if ($workflowDocumentType !== null) {
            $fieldsToUpdate['DOCUMENT_TYPE'] = $workflowDocumentType->toArray();
        }
        if ($name !== null) {
            $fieldsToUpdate['NAME'] = $name;
        }
        if ($description !== null) {
            $fieldsToUpdate['DESCRIPTION'] = $description;
        }
        if ($workflowAutoExecutionType !== null) {
            $fieldsToUpdate['AUTO_EXECUTE'] = (string)$workflowAutoExecutionType->value;
        }
        if ($filename !== null) {
            $fieldsToUpdate['TEMPLATE_DATA'] = $this->base64Encoder->encodeFile($filename);
        }
        if (count($fieldsToUpdate) === 0) {
            throw new InvalidArgumentException('no fields to update – you must set minimum one field to update');
        }

        return new UpdatedItemResult($this->core->call(
            'bizproc.workflow.template.update', [
                'ID' => $templateId,
                'FIELDS' => $fieldsToUpdate
            ]
        ));
    }

    /**
     * The method deletes workflow template. Requires the administrator access permissions.
     *
     * This method deletes only the templates created via the method bizproc.workflow.template.add,
     * because such templates are bound to an app and only they can be deleted.
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_delete.php
     */
    #[ApiEndpointMetadata(
        'bizproc.workflow.template.delete',
        'https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_delete.php',
        'The method deletes workflow template. Requires the administrator access permissions.'
    )]
    public function delete(int $templateId): DeletedItemResult
    {
        return new DeletedItemResult($this->core->call('bizproc.workflow.template.delete', [
            'ID' => $templateId
        ]));
    }

    /**
     * The method bizproc.workflow.template.list returns list of workflow templates, specified for a site. This method requires administrator access permissions.
     * @return Workflows\Template\Result\WorkflowTemplatesResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_list.php
     */
    #[ApiEndpointMetadata(
        'bizproc.workflow.template.list',
        'https://training.bitrix24.com/rest_help/workflows/wirkflow_template/bizproc_workflow_template_list.php',
        'The method bizproc.workflow.template.list returns list of workflow templates, specified for a site. '
    )]
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