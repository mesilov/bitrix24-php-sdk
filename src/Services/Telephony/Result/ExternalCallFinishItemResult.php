<?php

declare(strict_types=1);

/*
 * This file is part of the bitrix24-php-sdk package.
 *
 *  Kirill  Кhramov <k_hram@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Services\Telephony\Result;


use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * @property-read string $CALL_ID
 * @property-read int $EXTERNAL_CALL_ID
 * @property-read int $PORTAL_USER_ID
 * @property-read string $PHONE_NUMBER
 * @property-read string $PORTAL_NUMBER
 * @property-read string $INCOMING
 * @property-read int $CALL_DURATION
 * @property-read array $CALL_START_DATE
 * @property-read int $CALL_STATUS
 * @property-read int $CALL_VOTE
 * @property-read int $COST
 * @property-read string $COST_CURRENCY
 * @property-read string $CALL_FAILED_CODE
 * @property-read string $CALL_FAILED_REASON
 * @property-read int  $REST_APP_ID
 * @property-read bool $REST_APP_NAME
 * @property-read int $CRM_ACTIVITY_ID
 * @property-read string $COMMENT
 * @property-read string $CRM_ENTITY_TYPE
 * @property-read int $CRM_ENTITY_ID
 * @property-read int $ID
 *
 */
class ExternalCallFinishItemResult extends AbstractItem
{

}