<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Fields;

class FieldsFilter
{
    public function filterSystemFields(array $fieldCodes): array
    {
        $res = [];
        foreach ($fieldCodes as $fieldCode) {
            if (strncmp($fieldCode, 'UF_CRM_', 7) !== 0) {
                $res[] = $fieldCode;
            }
        }

        return $res;
    }
}
