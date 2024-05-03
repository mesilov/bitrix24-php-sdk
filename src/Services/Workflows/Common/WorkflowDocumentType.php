<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Common;

readonly class WorkflowDocumentType
{
    public function __construct(
        public string $moduleId,
        public string $entityId,
        public string $targetDocumentId,
    )
    {
    }

    public function toArray(): array
    {
        return [$this->moduleId, $this->entityId, $this->targetDocumentId];
    }

    public static function buildForLead(): self
    {
        return new self('crm', 'CCrmDocumentLead', 'LEAD');
    }

    public static function buildForContact(): self
    {
        return new self('crm', 'CCrmDocumentContact', 'CONTACT');
    }

    public static function buildForDeal(): self
    {
        return new self('crm', 'CCrmDocumentDeal', 'Deal');
    }
}

// ['crm', 'CCrmDocumentLead', 'LEAD']
// ['lists', 'BizprocDocument', 'iblock_22']
// ['disk', 'Bitrix\Disk\BizProcDocument', 'STORAGE_490']
// ['tasks', 'Bitrix\Tasks\Integration\Bizproc\Document\Task', 'TASK_PROJECT_13']