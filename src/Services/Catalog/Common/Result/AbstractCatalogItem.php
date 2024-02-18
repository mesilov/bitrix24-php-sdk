<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Catalog\Common\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Catalog\Common\ProductType;
use Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException;
use DateTimeImmutable;
use Money\Currency;
use Money\Money;

abstract class AbstractCatalogItem extends AbstractItem
{
    private const CRM_USERFIELD_PREFIX = 'UF_CRM_';

    /**
     * @var Currency
     */
    private Currency $currency;

    public function __construct(array $data, Currency $currency = null)
    {
        parent::__construct($data);
        if ($currency !== null) {
            $this->currency = $currency;
        }
    }

    /**
     * @param int|string $offset
     *
     * @return bool|DateTimeImmutable|int|mixed|null
     */

    public function __get($offset)
    {
        switch ($offset) {
            case 'active':
            case 'available':
            case 'bundle':
                return $this->data[$offset] === 'Y';
            case 'barcodeMulti':
            case 'canBuyZero':
                if ($this->data[$offset] !== null) {
                    return $this->data[$offset] === 'Y';
                }
                return null;
            case 'code':
            case 'detailText':
            case 'detailTextType':
            case 'name':
            case 'previewText':
            case 'previewTextType':
            case 'xmlId':
                return (string)$this->data[$offset];
            case 'createdBy':
            case 'iblockId':
            case 'iblockSectionId':
            case 'id':
            case 'modifiedBy':
            case 'sort':
            case 'height':
            case 'length':
                if ($this->data[$offset] !== '' && $this->data[$offset] !== null) {
                    return (int)$this->data[$offset];
                }
                break;
            case 'dateActiveFrom':
            case 'dateActiveTo':
            case 'dateCreate':
            case 'timestampX':
                if ($this->data[$offset] !== '') {
                    return DateTimeImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }

                return null;
            case 'type':
                return ProductType::from($this->data[$offset]);
        }

        return $this->data[$offset] ?? null;
    }

    /**
     * get userfield by field name
     *
     * @param string $fieldName
     *
     * @return mixed|null
     * @throws UserfieldNotFoundException
     */
    protected function getKeyWithUserfieldByFieldName(string $fieldName)
    {
        if (!str_starts_with($fieldName, self::CRM_USERFIELD_PREFIX)) {
            $fieldName = self::CRM_USERFIELD_PREFIX . $fieldName;
        }
        if (!$this->isKeyExists($fieldName)) {
            throw new UserfieldNotFoundException(sprintf('crm userfield not found by field name %s', $fieldName));
        }

        return $this->$fieldName;
    }
}