<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Fields;

class FieldsFilter
{
    public function filterSystemFields(array $fieldCodes): array
    {
        $res = [];
        foreach ($fieldCodes as $fieldCode) {
            if (!str_starts_with((string) $fieldCode, 'UF_CRM_')) {
                $res[] = $fieldCode;
            }
        }

        return $res;
    }
}
