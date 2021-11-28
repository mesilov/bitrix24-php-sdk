<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Userfield\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $ID
 * @property-read string $ENTITY_ID
 * @property-read string $FIELD_NAME
 * @property-read string $USER_TYPE_ID
 * @property-read string $XML_ID
 * @property-read string $SORT
 * @property-read string $MULTIPLE
 * @property-read string $MANDATORY
 * @property-read string $SHOW_FILTER
 * @property-read string $SHOW_IN_LIST
 * @property-read string $EDIT_IN_LIST
 * @property-read string $IS_SEARCHABLE
 * @property-read array  $EDIT_FORM_LABEL
 * @property-read array  $LIST_COLUMN_LABEL
 * @property-read array  $LIST_FILTER_LABEL
 * @property-read string $ERROR_MESSAGE
 * @property-read string $HELP_MESSAGE
 * @property-read array  $LIST
 * @property-read array  $SETTINGS
 */
class AbstractUserfieldItemResult extends AbstractItem
{
    //crm userfield name prefix UF_CRM_
    private const CRM_USERFIELD_PREFIX_LENGTH = 7;

    /**
     * get userfield name without prefix UF_CRM_
     *
     * @return string
     */
    public function getOriginalFieldName(): string
    {
        return substr($this->FIELD_NAME, self::CRM_USERFIELD_PREFIX_LENGTH);
    }
}