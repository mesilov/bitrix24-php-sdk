<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitrix24\Presets\Event;

/**
 * Class Event
 * @package Bitrix24\Presets\Event
 */
class Event
{
    /**
     * @var string event code when bitrix24 application has uninstall
     */
    const ON_APP_UNINSTALL = 'ONAPPUNINSTALL';
    /**
     * @var string event code when bitrix24 application install
     */
    const ON_APP_INSTALL = 'ONAPPINSTALL';
    /**
     * @var string event code when bitrix24 application update
     */
    const ON_APP_UPDATE = 'ONAPPUPDATE';
    /**
     * @var string event code when bitrix24 application payment
     */
    const ON_APP_PAYMENT = 'ONAPPPAYMENT';
    /**
     * @var string
     */
    const ON_APP_TEST = 'ONAPPTEST';
    /**
     * @var string event code when task add in bitrix24
     */
    const ON_TASK_ADD = 'ONTASKADD';
    /**
     * @var string
     */
    const ON_VOXIMPLANT_CALL_INIT = 'ONVOXIMPLANTCALLINIT';
    /**
     * @var string
     */
    const ON_VOXIMPLANT_CALL_START = 'ONVOXIMPLANTCALLSTART';
    /**
     * @var string
     */
    const ON_VOXIMPLANT_CALL_END = 'ONVOXIMPLANTCALLEND';
    /**
     * @var string event code when task in bitrix24 has update
     */
    const ON_TASK_UPDATE = 'ONTASKUPDATE';
    /**
     * @var string event code when task in bitrix24 has delete
     */
    const ON_TASK_DELETE = 'ONTASKDELETE';
    /**
     * @var string
     */
    const ON_TASK_COMMENT_ADD = 'ONTASKCOMMENTADD';
    /**
     * @var string
     */
    const ON_TASK_COMMENT_UPDATE = 'ONTASKCOMMENTUPDATE';
    /**
     * @var string
     */
    const ON_TASK_COMMENT_DELETE = 'ONTASKCOMMENTDELETE';
    /**
     * @var string event code when new user in bitrix24 has added
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
    /**
     * @var string
     */
    const ON_CRM_QUOTE_ADD = 'ONCRMQUOTEADD';
    /**
     * @var string
     */
    const ON_CRM_QUOTE_UPDATE = 'ONCRMQUOTEUPDATE';
    /**
     * @var string
     */
    const ON_CRM_QUOTE_DELETE = 'ONCRMQUOTEDELETE';
    /**
     * @var string event on bot add to chat or private chat
     */
    const ON_IM_BOT_JOIN_CHAT = 'ONIMBOTJOINCHAT';
    /**
     * @var string event on bot delete
     */
    const ON_IM_BOT_DELETE = 'ONIMBOTDELETE';
    /**
     * @var string event on bot gets message
     */
    const ON_IM_BOT_MESSAGE_ADD = 'ONIMBOTMESSAGEADD';
    /**
     * @var string event on bot gets command
     */
    const ON_IM_COMMAND_ADD = 'ONIMCOMMANDADD';
}
