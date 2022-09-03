<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity\Result;

use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use DateTimeInterface;

/**
 * @see https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_fields.php
 *
 * @property-read int    $ID                        // Activity ID
 * @property-read int    $OWNER_ID
 * @property-read string $OWNER_TYPE_ID
 * @property-read string $TYPE_ID
 * @property-read string $PROVIDER_ID
 * @property-read string $PROVIDER_TYPE_ID
 * @property-read string $PROVIDER_GROUP_ID
 * @property-read int    $ASSOCIATED_ENTITY_ID      // ID of an entity associated with the activity
 * @property-read string $SUBJECT
 * @property-read string $START_TIME
 * @property-read string $END_TIME                  // Completion time
 * @property-read string $DEADLINE                  // Deadline
 * @property-read string $COMPLETED                 // Completed
 * @property-read string $STATUS
 * @property-read string $RESPONSIBLE_ID
 * @property-read string $PRIORITY
 * @property-read string $NOTIFY_TYPE               // Notification type with crm_enum_activitynotifytype type
 * @property-read int    $NOTIFY_VALUE
 * @property-read string $DESCRIPTION               // Description
 * @property-read string $DESCRIPTION_TYPE          // Description type with crm_enum_contenttype type
 * @property-read string $DIRECTION                 // with crm_enum_activitydirection type
 * @property-read string $LOCATION                  // Location
 * @property-read string $CREATED
 * @property-read string $AUTHOR_ID                 // Activity author ID
 * @property-read string $LAST_UPDATED              // Date of the last update date
 * @property-read string $EDITOR_ID                 // Editor
 * @property-read array  $SETTINGS
 * @property-read string $ORIGIN_ID
 * @property-read string $ORIGINATOR_ID
 * @property-read int    $RESULT_STATUS
 * @property-read int    $RESULT_STREAM
 * @property-read string $RESULT_SOURCE_ID
 * @property-read array  $PROVIDER_PARAMS
 * @property-read string $PROVIDER_DATA
 * @property-read int    $RESULT_MARK
 * @property-read string $RESULT_VALUE
 * @property-read string $RESULT_SUM
 * @property-read string $RESULT_CURRENCY_ID
 * @property-read int    $AUTOCOMPLETE_RULE         // Autocompletion
 * @property-read string $BINDINGS                  // Bindings
 * @property-read array  $COMMUNICATIONS            // type crm_activity_communication
 * @property-read array  $FILES                     // Added files with diskfile type
 * @property-read string $WEBDAV_ELEMENTS
 */
class ActivityItemResult extends AbstractCrmItem
{
}