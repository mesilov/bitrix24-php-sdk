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

namespace Bitrix24\SDK\Services\Catalog\Common\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Catalog\Common\ProductType;
use Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException;
use Carbon\CarbonImmutable;
use Money\Currency;

abstract class AbstractCatalogItem extends AbstractItem
{
    private const CRM_USERFIELD_PREFIX = 'UF_CRM_';

    private Currency $currency;

    public function __construct(array $data, Currency $currency = null)
    {
        parent::__construct($data);
        if ($currency instanceof Currency) {
            $this->currency = $currency;
        }
    }

    /**
     * @param int|string $offset
     *
     * @return bool|CarbonImmutable|int|mixed|null
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
                    return CarbonImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
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