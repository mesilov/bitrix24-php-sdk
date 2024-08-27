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

namespace Bitrix24\SDK\Services\Telephony\ExternalCall\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntity;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Money\Currency;
use Money\Money;

/**
 * @property-read  string $CALL_ID Call ID inside Bitrix24.
 * @property-read  string|null $EXTERNAL_CALL_ID
 * @property-read  int $PORTAL_USER_ID
 * @property-read  string $PHONE_NUMBER
 * @property-read  string $PORTAL_NUMBER
 * @property-read  bool $INCOMING
 * @property-read  int $CALL_DURATION
 * @property-read  array $CALL_START_DATE
 * @property-read  int $CALL_STATUS
 * @property-read  int $CALL_VOTE
 * @property-read  Money $COST
 * @property-read  Currency $COST_CURRENCY
 * @property-read  int $CALL_FAILED_CODE
 * @property-read  string $CALL_FAILED_REASON
 * @property-read  string $REST_APP_ID
 * @property-read  bool $REST_APP_NAME
 * @property-read  int $CRM_ACTIVITY_ID
 * @property-read  string|null $COMMENT
 * @property-read  CrmEntityType $CRM_ENTITY_TYPE
 * @property-read  int $CRM_ENTITY_ID
 * @property-read  int $ID
 */
class ExternalCallFinishedItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
            case 'COST':
                return $this->decimalMoneyParser->parse((string)$this->data[$offset], new Currency($this->data['COST_CURRENCY']));
            case 'COST_CURRENCY':
                return new Currency($this->data[$offset]);
            case 'INCOMING':
                return $this->data[$offset] === '1';
            case 'PORTAL_USER_ID':
            case 'CALL_STATUS':
            case 'CALL_VOTE':
            case 'CALL_FAILED_CODE':
            case 'CRM_ACTIVITY_ID':
            case 'CRM_ENTITY_ID':
            case 'ID':
                return (int)$this->data[$offset];
            case'CRM_ENTITY_TYPE':
                return CrmEntityType::from($this->data[$offset]);
            case 'CRM_CREATED_ENTITIES':
                $res = [];
                foreach ($this->data[$offset] as $item) {
                    $res[] = new CrmEntity(
                        (int)$item['ENTITY_ID'],
                        CrmEntityType::from($item['ENTITY_TYPE'])
                    );
                }

                return $res;
            default:
                return $this->data[$offset] ?? null;
        }
    }
}