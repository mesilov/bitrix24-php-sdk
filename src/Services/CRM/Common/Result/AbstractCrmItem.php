<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Common\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException;
use DateTimeImmutable;

class AbstractCrmItem extends AbstractItem
{
    private const CRM_USERFIELD_PREFIX = 'UF_CRM_';

    /**
     * @param int|string $offset
     *
     * @return bool|\DateTimeImmutable|int|mixed|null
     */
    public function __get($offset)
    {
        //todo унести в отдельный класс и покрыть тестами
        switch ($offset) {
            case 'ID':
            case 'ASSIGNED_BY_ID':
            case 'CREATED_BY_ID':
            case 'MODIFY_BY_ID':
                return (int)$this->data[$offset];
            case 'EXPORT':
            case 'HAS_PHONE':
            case 'HAS_EMAIL':
            case 'HAS_IMOL':
            case 'OPENED':
                return $this->data[$offset] === 'Y';
            case 'DATE_CREATE':
            case 'DATE_MODIFY':
            case 'BIRTHDATE':
                if ($this->data[$offset] !== '') {
                    return DateTimeImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }

                return null;
            default:
                return $this->data[$offset] ?? null;
        }
    }

    /**
     * get userfield by field name
     *
     * @param string $fieldName
     *
     * @return mixed|null
     * @throws \Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException
     */
    protected function getKeyWithUserfieldByFieldName(string $fieldName)
    {
        $fieldName = self::CRM_USERFIELD_PREFIX . $fieldName;
        if (!$this->isKeyExists($fieldName)) {
            throw new UserfieldNotFoundException(sprintf('crm userfield not found by field name %s', $fieldName));
        }

        return $this->$fieldName;
    }
}