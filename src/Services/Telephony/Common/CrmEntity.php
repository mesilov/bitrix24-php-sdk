<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

readonly class CrmEntity
{
    public function __construct(
        public int           $id,
        public CrmEntityType $type
    )
    {
    }
}