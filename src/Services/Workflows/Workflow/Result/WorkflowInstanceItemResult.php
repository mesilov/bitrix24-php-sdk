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

namespace Bitrix24\SDK\Services\Workflows\Workflow\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowAutoExecutionType;
use Carbon\CarbonImmutable;

/**
 * @property-read string $ID workflow ID
 * @property-read CarbonImmutable $MODIFIED
 * @property-read ?CarbonImmutable $OWNED_UNTIL time for blocking of a workflow. Process is considered as unresponsive, if the difference of blocking time with the current time is more than 5 minutes;
 * @property-read ?CarbonImmutable $STARTED workflow launch date;
 * @property-read ?string $MODULE_ID module ID (as per document);
 * @property-read ?string $ENTITY entity ID (as per document);
 * @property-read ?int $DOCUMENT_ID document ID;
 * @property-read ?int $STARTED_BY who launched the workflow;
 * @property-read ?int $TEMPLATE_ID workflow template ID.
 */
class WorkflowInstanceItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
            case 'STARTED_BY':
            case 'TEMPLATE_ID':
                return (int)$this->data[$offset];
            case 'DOCUMENT_ID':
                if ($this->data[$offset] !== '') {
                    // "DEAL_158310"
                    return (int)substr((string) $this->data[$offset], strpos((string) $this->data[$offset], '_')+1);
                }
                return null;
            case 'MODIFIED':
            case 'STARTED':
                if ($this->data[$offset] !== '') {
                    return CarbonImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }
                return null;
        }
        return $this->data[$offset] ?? null;
    }
}