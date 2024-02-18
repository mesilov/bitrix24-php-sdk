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
 * If registration of the call was unsuccessful, the LEAD_CREATION_ERROR field will contain the error message.
 *
 * @property-read  string $CALL_ID
 * @property-read  ?int $CRM_CREATED_LEAD
 * @property-read  ?int $CRM_ENTITY_ID
 * @property-read  string $CRM_ENTITY_TYPE
 * @property-read  array $CRM_CREATED_ENTITIES
 * @property-read  string $LEAD_CREATION_ERROR
 */
class ExternalCallRegisterItemResult extends AbstractItem
{
    /**
     * @return bool
     */
    public function isError(): bool
    {
        if (!$this->isKeyExists('LEAD_CREATION_ERROR')) {
            return false;
        }
        return $this->data['LEAD_CREATION_ERROR'] !== '' && $this->data['LEAD_CREATION_ERROR'] !== null;
    }
}