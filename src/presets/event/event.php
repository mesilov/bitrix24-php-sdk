<?php

namespace Bitrix24\Presets\Event;

/**
 * Class Event.
 */
class event
{
    /**
     * event code when bitrix24 application has uninstall.
     */
    const ON_APP_UNINSTALL = 'ONAPPUNINSTALL';
    /**
     * event code when bitrix24 application update.
     */
    const ON_APP_UPDATE = 'ONAPPUPDATE';
    /**
     * event code when bitrix24 application payment.
     */
    const ON_APP_PAYMENT = 'ONAPPPAYMENT';
    /**
     * event code when task add in bitrix24.
     */
    const ON_TASK_ADD = 'ONTASKADD';
    /**
     * event code when task in bitrix24 has update.
     */
    const ON_TASK_UPDATE = 'ONTASKUPDATE';
    /**
     * event code when task in bitrix24 has delete.
     */
    const ON_TASK_DELETE = 'ONTASKDELETE';
    /**
     * event code when new user in bitrix24 has added.
     */
    const ON_USER_ADD = 'ONUSERADD';
    /**
     * @var string
     */
    const ON_CRM_LEAD_ADD = 'ONCRMLEADADD';
    /**
     * @var string
     */
    const ON_CRM_LEAD_UPDATE = 'ONCRMLEADUPDATE';
    /**
     * @var string
     */
    const ON_CRM_LEAD_DELETE = 'ONCRMLEADDELETE';
    /**
     * @var string
     */
    const ON_CRM_DEAL_ADD = 'ONCRMDEALADD';
    /**
     * @var string
     */
    const ON_CRM_DEAL_UPDATE = 'ONCRMDEALUPDATE';
    /**
     * @var string
     */
    const ON_CRM_DEAL_DELETE = 'ONCRMDEALDELETE';
    /**
     * @var string
     */
    const ON_CRM_COMPANY_ADD = 'ONCRMCOMPANYADD';
    /**
     * @var string
     */
    const ON_CRM_COMPANY_UPDATE = 'ONCRMCOMPANYUPDATE';
    /**
     * @var string
     */
    const ON_CRM_COMPANY_DELETE = 'ONCRMCOMPANYDELETE';
    /**
     * @var string
     */
    const ON_CRM_CONTACT_ADD = 'ONCRMCONTACTADD';
    /**
     * @var string
     */
    const ON_CRM_CONTACT_UPDATE = 'ONCRMCONTACTUPDATE';
    /**
     * @var string
     */
    const ON_CRM_CONTACT_DELETE = 'ONCRMCONTACTDELETE';
    /**
     * @var string
     */
    const ON_CRM_CURRENCY_ADD = 'ONCRMCURRENCYADD';
    /**
     * @var string
     */
    const ON_CRM_CURRENCY_UPDATE = 'ONCRMCURRENCYUPDATE';
    /**
     * @var string
     */
    const ON_CRM_CURRENCY_DELETE = 'ONCRMCURRENCYDELETE';
    /**
     * @var string
     */
    const ON_CRM_PRODUCT_ADD = 'ONCRMPRODUCTADD';
    /**
     * @var string
     */
    const ON_CRM_PRODUCT_UPDATE = 'ONCRMPRODUCTUPDATE';
    /**
     * @var string
     */
    const ON_CRM_PRODUCT_DELETE = 'ONCRMPRODUCTDELETE';
    /**
     * @var string
     */
    const ON_CRM_ACTIVITY_ADD = 'ONCRMACTIVITYADD';
    /**
     * @var string
     */
    const ON_CRM_ACTIVITY_UPDATE = 'ONCRMACTIVITYUPDATE';
    /**
     * @var string
     */
    const ON_CRM_ACTIVITY_DELETE = 'ONCRMACTIVITYDELETE';
}
