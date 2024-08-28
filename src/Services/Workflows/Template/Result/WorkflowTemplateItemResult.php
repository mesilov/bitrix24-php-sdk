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

namespace Bitrix24\SDK\Services\Workflows\Template\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowAutoExecutionType;
use Carbon\CarbonImmutable;

/**
 * @property-read int $ID
 * @property-read ?string $MODULE_ID
 * @property-read ?string $ENTITY
 * @property-read ?array $DOCUMENT_TYPE
 * @property-read ?WorkflowAutoExecutionType $AUTO_EXECUTE
 * @property-read ?string $NAME
 * @property-read ?array $TEMPLATE
 * @property-read ?array $PARAMETERS
 * @property-read ?array $VARIABLES
 * @property-read ?array $CONSTANTS
 * @property-read ?CarbonImmutable $MODIFIED
 * @property-read ?bool $IS_MODIFIED
 * @property-read ?int $USER_ID
 * @property-read ?string $SYSTEM_CODE
 */
class WorkflowTemplateItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
            case 'ID':
            case 'USER_ID':
                return (int)$this->data[$offset];
            case 'AUTO_EXECUTE':
                if ($this->data[$offset] !== null) {
                    return WorkflowAutoExecutionType::from((int)$this->data[$offset]);
                }
                return null;
            case 'MODIFIED':
                if ($this->data[$offset] !== '') {
                    return CarbonImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }
                return null;
            case 'IS_MODIFIED':
                return $this->data[$offset] === 'Y';
        }
        return $this->data[$offset] ?? null;
    }
}