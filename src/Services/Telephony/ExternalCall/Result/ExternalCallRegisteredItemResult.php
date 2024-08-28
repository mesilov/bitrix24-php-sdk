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

/**
 * @property-read  string $CALL_ID Call ID inside Bitrix24.
 * @property-read  ?int $CRM_CREATED_LEAD Created lead ID (is created, if the object is not found in CRM by the incoming number)
 * @property-read  CrmEntity[] $CRM_CREATED_ENTITIES Array with entities automatically created in CRM when registering a call.
 * @property-read  CrmEntityType $CRM_ENTITY_TYPE Type of the object found in CRM by the incoming number CONTACT | COMPANY | LEAD.
 * @property-read  ?int $CRM_ENTITY_ID ID of the object found in CRM.
 * @property-read  string $LEAD_CREATION_ERROR Error text, occurring when creating a lead in CRM.
 */
class ExternalCallRegisteredItemResult extends AbstractItem
{
    public function __get($offset)
    {
        switch ($offset) {
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

    public function isError(): bool
    {
        if (!$this->isKeyExists('LEAD_CREATION_ERROR')) {
            return false;
        }

        return $this->data['LEAD_CREATION_ERROR'] !== '' && $this->data['LEAD_CREATION_ERROR'] !== null;
    }
}