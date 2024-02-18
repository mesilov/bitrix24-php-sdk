<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Common\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Email;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\InstantMessenger;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Phone;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\PhoneValueType;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Website;
use Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException;
use DateTimeImmutable;
use Money\Currency;
use Money\Money;

class AbstractCrmItem extends AbstractItem
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
        // todo унести в отдельный класс и покрыть тестами
        // учитывать требования
        //  - поддержка пользовательских полей с пользовательскими типами
        //  - поддержка пользовательских полей со встроенными типами
        //  - расширяемость для пользовательских полей в клиентском коде
        //  - хранение связи поле-тип в аннотациях?

        // приведение полей к реальным типам данных для основных сущностей CRM
        switch ($offset) {
            case 'ID':
            case 'ASSIGNED_BY_ID':
            case 'CREATED_BY_ID':
            case 'MODIFY_BY_ID':
            case 'createdBy':
            case 'updatedBy':
            case 'movedBy':
            case 'begindate':
            case 'closedate':
            case 'opportunity':
            case 'opportunityAccount':
            case 'taxValueAccount':
            case 'taxValue':
                // deal
            case 'LEAD_ID':
            case 'CONTACT_ID':
            case 'QUOTE_ID':
                // productRow
            case 'OWNER_ID':
                // DealCategoryItem
            case 'SORT':
            case 'id':
            case 'categoryId':
            case 'webformId':
            case 'assignedById':
            case 'contactId':
            case 'lastActivityBy':
                if ($this->data[$offset] !== '' && $this->data[$offset] !== null) {
                    return (int)$this->data[$offset];
                }

                return null;
            case 'COMPANY_ID':
            case 'companyId':
            case 'mycompanyId':
                if ($this->data[$offset] !== '' && $this->data[$offset] !== null && $this->data[$offset] !== '0') {
                    return (int)$this->data[$offset];
                }
                return null;
            // contact
            case 'EXPORT':
            case 'HAS_PHONE':
            case 'HAS_EMAIL':
            case 'HAS_IMOL':
            case 'OPENED':
            case 'opened':
            case 'IS_MANUAL_OPPORTUNITY':
            case 'isManualOpportunity':
            case 'CLOSED':
            case 'IS_NEW':
            case 'IS_LOCKED':
            case 'IS_RECURRING':
            case 'IS_RETURN_CUSTOMER':
            case 'IS_REPEATED_APPROACH':
                return $this->data[$offset] === 'Y';
            case 'DATE_CREATE':
            case 'CREATED_DATE':
            case 'DATE_MODIFY':
            case 'BIRTHDATE':
            case 'BEGINDATE':
            case 'CLOSEDATE':
            case 'createdTime':
            case 'updatedTime':
            case 'movedTime':
            case 'lastActivityTime':
                if ($this->data[$offset] !== '') {
                    return DateTimeImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }

                return null;
            // deal
            case 'PRICE_EXCLUSIVE':
            case 'PRICE_NETTO':
            case 'PRICE_BRUTTO':
            case 'PRICE':
                if ($this->data[$offset] !== '' && $this->data[$offset] !== null) {
                    $var = $this->data[$offset] * 100;
                    return new Money((string)$var, new Currency($this->currency->getCode()));
                }
                return null;
            case 'PHONE':
                if (!$this->isKeyExists($offset)) {
                    return [];
                }

                $items = [];
                foreach ($this->data[$offset] as $item) {
                    $items[] = new Phone($item);
                }
                return $items;
            case 'EMAIL':
                if (!$this->isKeyExists($offset)) {
                    return [];
                }

                $items = [];
                foreach ($this->data[$offset] as $item) {
                    $items[] = new Email($item);
                }
                return $items;
            case 'WEB':
                if (!$this->isKeyExists($offset)) {
                    return [];
                }

                $items = [];
                foreach ($this->data[$offset] as $item) {
                    $items[] = new Website($item);
                }
                return $items;
            case 'IM':
                if (!$this->isKeyExists($offset)) {
                    return [];
                }

                $items = [];
                foreach ($this->data[$offset] as $item) {
                    $items[] = new InstantMessenger($item);
                }
                return $items;
            case 'currencyId':
            case 'accountCurrencyId':
                return new Currency($this->data[$offset]);
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