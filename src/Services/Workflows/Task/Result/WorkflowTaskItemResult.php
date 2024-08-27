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

namespace Bitrix24\SDK\Services\Workflows\Task\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Workflows\Common\DocumentType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowAutoExecutionType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskActivityType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskStatusType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowTaskUserStatusType;
use Carbon\CarbonImmutable;

/**
 * @property-read int $ID task ID
 * @property-read ?string $WORKFLOW_ID workflow ID
 * @property-read ?string $DOCUMENT_NAME document name
 * @property-read ?string $DESCRIPTION task description
 * @property-read ?string $NAME task name
 * @property-read ?CarbonImmutable $MODIFIED date of modification
 * @property-read ?CarbonImmutable $WORKFLOW_STARTED date of workflow launch
 * @property-read ?int $WORKFLOW_STARTED_BY who launched the workflow
 * @property-read ?CarbonImmutable $OVERDUE_DATE deadline
 * @property-read ?int $WORKFLOW_TEMPLATE_ID workflow template ID
 * @property-read ?string $WORKFLOW_TEMPLATE_NAME workflow template name
 * @property-read ?string $WORKFLOW_STATE workflow status description
 * @property-read ?WorkflowTaskStatusType $STATUS task status
 * @property-read ?int $USER_ID user id
 * @property-read ?WorkflowTaskUserStatusType $USER_STATUS user response status
 * @property-read ?string $MODULE_ID module id (for document)
 * @property-read ?DocumentType $ENTITY entity ID (for document)
 * @property-read ?int $DOCUMENT_ID document ID
 * @property-read ?WorkflowTaskActivityType $ACTIVITY task type ID
 * @property-read ?array $PARAMETERS task parameters
 * @property-read ?string $DOCUMENT_URL document URL
 */
class WorkflowTaskItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
            case 'ID':
            case 'WORKFLOW_TEMPLATE_ID':
            case 'USER_ID':
                return (int)$this->data[$offset];
            case 'DOCUMENT_ID':
                if ($this->data[$offset] !== '') {
                    return (int)substr((string) $this->data[$offset], strrpos((string) $this->data[$offset], '_') + 1);
                }
                return null;
            case 'MODIFIED':
            case 'WORKFLOW_STARTED':
            case 'OVERDUE_DATE':
                if ($this->data[$offset] !== '') {
                    return CarbonImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }
                return null;
            case 'STATUS':
                if ($this->data[$offset] !== '') {
                    return WorkflowTaskStatusType::from((int)$this->data[$offset]);
                }
                return null;
            case 'USER_STATUS':
                if ($this->data[$offset] !== '') {
                    return WorkflowTaskUserStatusType::from((int)$this->data[$offset]);
                }
                return null;
            case 'ENTITY':
                if ($this->data[$offset] !== '') {
                    return DocumentType::from($this->data[$offset]);
                }
                return null;
            case 'ACTIVITY':
                if ($this->data[$offset] !== '') {
                    return WorkflowTaskActivityType::from($this->data[$offset]);
                }
                return null;
            case 'PARAMETERS':
                if ($this->data[$offset] !== '') {
                    return $this->data[$offset];
                }
                return null;
        }
        return $this->data[$offset] ?? null;
    }
}