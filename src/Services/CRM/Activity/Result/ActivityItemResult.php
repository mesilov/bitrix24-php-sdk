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

namespace Bitrix24\SDK\Services\CRM\Activity\Result;

use Bitrix24\SDK\Services\CRM\Activity\ActivityContentType;
use Bitrix24\SDK\Services\CRM\Activity\ActivityDirectionType;
use Bitrix24\SDK\Services\CRM\Activity\ActivityNotifyType;
use Bitrix24\SDK\Services\CRM\Activity\ActivityPriority;
use Bitrix24\SDK\Services\CRM\Activity\ActivityStatus;
use Bitrix24\SDK\Services\CRM\Activity\ActivityType;
use Bitrix24\SDK\Services\CRM\Common\Result\AbstractCrmItem;
use Carbon\CarbonImmutable;
use Money\Currency;
use Money\Money;

/**
 * @see https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_fields.php
 *
 * @property-read int $ID                        // Activity ID
 * @property-read int $OWNER_ID
 * @property-read string $OWNER_TYPE_ID
 * @property-read ActivityType $TYPE_ID
 * @property-read string $PROVIDER_ID
 * @property-read string $PROVIDER_TYPE_ID
 * @property-read string $PROVIDER_GROUP_ID
 * @property-read int $ASSOCIATED_ENTITY_ID      // ID of an entity associated with the activity
 * @property-read string $SUBJECT
 * @property-read string $START_TIME
 * @property-read string $END_TIME                  // Completion time
 * @property-read CarbonImmutable $DEADLINE                  // Deadline
 * @property-read boolean $COMPLETED                 // Completed
 * @property-read ActivityStatus $STATUS
 * @property-read int $RESPONSIBLE_ID
 * @property-read ActivityPriority $PRIORITY
 * @property-read ActivityNotifyType $NOTIFY_TYPE               // Notification type with crm_enum_activitynotifytype type
 * @property-read int $NOTIFY_VALUE
 * @property-read string $DESCRIPTION               // Description
 * @property-read ActivityContentType $DESCRIPTION_TYPE          // Description type with crm_enum_contenttype type
 * @property-read ActivityDirectionType $DIRECTION                 // with crm_enum_activity direction type
 * @property-read string|null $LOCATION                  // Location
 * @property-read CarbonImmutable $CREATED
 * @property-read int $AUTHOR_ID                 // Activity author ID
 * @property-read CarbonImmutable $LAST_UPDATED              // Date of the last update date
 * @property-read int $EDITOR_ID                 // Editor
 * @property-read array $SETTINGS
 * @property-read string|null $ORIGIN_ID
 * @property-read string|null $ORIGINATOR_ID
 * @property-read int $RESULT_STATUS
 * @property-read int $RESULT_STREAM
 * @property-read string|null $RESULT_SOURCE_ID
 * @property-read array $PROVIDER_PARAMS
 * @property-read string|null $PROVIDER_DATA
 * @property-read int $RESULT_MARK
 * @property-read string|null $RESULT_VALUE
 * @property-read Money|null $RESULT_SUM
 * @property-read Currency|null $RESULT_CURRENCY_ID
 * @property-read int $AUTOCOMPLETE_RULE         // Autocompletion
 * @property-read string $BINDINGS                  // Bindings
 * @property-read array $COMMUNICATIONS            // type crm_activity_communication
 * @property-read array $FILES                     // Added files with diskfile type
 * @property-read string $WEBDAV_ELEMENTS
 */
class ActivityItemResult extends AbstractCrmItem
{
}