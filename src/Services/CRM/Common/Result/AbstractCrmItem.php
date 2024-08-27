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

namespace Bitrix24\SDK\Services\CRM\Common\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\CRM\Activity\ActivityContentType;
use Bitrix24\SDK\Services\CRM\Activity\ActivityDirectionType;
use Bitrix24\SDK\Services\CRM\Activity\ActivityNotifyType;
use Bitrix24\SDK\Services\CRM\Activity\ActivityPriority;
use Bitrix24\SDK\Services\CRM\Activity\ActivityStatus;
use Bitrix24\SDK\Services\CRM\Activity\ActivityType;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Email;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\InstantMessenger;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Phone;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\PhoneValueType;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Website;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealSemanticStage;
use Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException;
use Carbon\CarbonImmutable;
use Money\Currency;
use Money\Money;
use MoneyPHP\Percentage\Percentage;

class AbstractCrmItem extends AbstractItem
{
    private Currency $currency;
    private const CRM_USERFIELD_PREFIX = 'UF_CRM_';

    /**
     * @param int|string $offset
     *
     * @return bool|CarbonImmutable|int|mixed|null
     */
    public function __get($offset)
    {
        // todo move to separate service
        //
        //  - add user fields with custom user types
        //  - add inheritance for user types

        switch ($offset) {
            case 'ID':
            case 'ASSIGNED_BY_ID':
            case 'RESPONSIBLE_ID':
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
            case 'LEAD_ID':
            case 'CONTACT_ID':
            case 'QUOTE_ID':
            case 'OWNER_ID':
            case 'SORT':
            case 'id':
            case 'categoryId':
            case 'webformId':
            case 'assignedById':
            case 'contactId':
            case 'lastActivityBy':
            case 'AUTHOR_ID':
            case 'EDITOR_ID':
            case 'RESULT_MARK':
            case 'RESULT_STATUS':
            case 'RESULT_STREAM':
            case 'LAST_ACTIVITY_BY':
            case 'ADDRESS_LOC_ADDR_ID':
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
            case 'TAX_INCLUDED':
            case 'CUSTOMIZED':
            case 'COMPLETED':
                return $this->data[$offset] === 'Y';
            case 'DATE_CREATE':
            case 'CREATED_DATE':
            case 'CREATED':
            case 'DEADLINE':
            case 'LAST_UPDATED':
            case 'DATE_MODIFY':
            case 'BIRTHDATE':
            case 'BEGINDATE':
            case 'CLOSEDATE':
            case 'createdTime':
            case 'updatedTime':
            case 'movedTime':
            case 'lastActivityTime':
            case 'LAST_ACTIVITY_TIME':
                if ($this->data[$offset] !== '') {
                    return CarbonImmutable::createFromFormat(DATE_ATOM, $this->data[$offset]);
                }

                return null;
            case 'PRICE_EXCLUSIVE':
            case 'PRICE_NETTO':
            case 'PRICE_BRUTTO':
            case 'PRICE':
            case 'DISCOUNT_SUM':
            case 'RESULT_SUM':
                if ($this->data[$offset] !== '' && $this->data[$offset] !== null) {
                    $var = $this->data[$offset] * 100;
                    return new Money((string)$var, new Currency($this->currency->getCode()));
                }
                return null;
            case 'RESULT_CURRENCY_ID':
                if ($this->data[$offset] !== '' && $this->data[$offset] !== null) {
                    return new Currency($this->data[$offset]);
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
            case 'CURRENCY_ID':
                return new Currency($this->data[$offset]);
            case 'STAGE_SEMANTIC_ID':
                if ($this->data[$offset] !== null) {
                    return DealSemanticStage::from($this->data[$offset]);
                }
                return null;
            case 'DISCOUNT_TYPE_ID':
                return DiscountType::from($this->data[$offset]);
            case 'DISCOUNT_RATE':
                return new Percentage((string)$this->data[$offset]);
            case 'TYPE_ID':
                return ActivityType::from((int)$this->data[$offset]);
            case 'STATUS':
                return ActivityStatus::from((int)$this->data[$offset]);
            case 'PRIORITY':
                return ActivityPriority::from((int)$this->data[$offset]);
            case 'NOTIFY_TYPE':
                return ActivityNotifyType::from((int)$this->data[$offset]);
            case 'DESCRIPTION_TYPE':
                return ActivityContentType::from((int)$this->data[$offset]);
            case 'DIRECTION':
                return ActivityDirectionType::from((int)$this->data[$offset]);
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
    protected function getKeyWithUserfieldByFieldName(string $fieldName): mixed
    {
        if (!str_starts_with($fieldName, self::CRM_USERFIELD_PREFIX)) {
            $fieldName = self::CRM_USERFIELD_PREFIX . $fieldName;
        }
        if (!$this->isKeyExists($fieldName)) {
            throw new UserfieldNotFoundException(sprintf('crm userfield not found by field name %s', $fieldName));
        }

        return $this->$fieldName;
    }

    public function __construct(array $data, Currency $currency = null)
    {
        parent::__construct($data);
        if ($currency !== null) {
            $this->currency = $currency;
        }
    }
}