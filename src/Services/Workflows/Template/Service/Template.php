<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Template\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Psr\Log\LoggerInterface;


class Template extends AbstractService
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