<?php
namespace Bitrix24\Presets\CRM\Invoice;
/**
 * Class Fields
 * @link http://dev.1c-bitrix.ru/rest_help/crm/invoice/crm_invoice_fields.php
 * @package Bitrix24\Presets\CRM\Invoice
 */
class Fields
{
    /**
     * @var string ACCOUNT_NUMBER - number of account, this field is required and is read only. Maximum length 100
     */
    const ACCOUNT_NUMBER		        = 'ACCOUNT_NUMBER';
    const COMMENTS		                = 'COMMENTS';
    const CURRENCY		                = 'CURRENCY';
    const DATE_BILL	                    = 'DATE_BILL';
    const DATE_INSERT		            = 'DATE_INSERT';
    const DATE_MARKED		            = 'DATE_MARKED';
    const DATE_PAY_BEFORE               = 'DATE_PAY_BEFORE';
    const DATE_PAYED		            = 'DATE_PAYED';
    const DATE_STATUS		            = 'DATE_STATUS';
    const DATE_UPDATE		            = 'DATE_UPDATE';
    const EMP_PAYED_ID		            = 'EMP_PAYED_ID';
    const EMP_STATUS_ID		            = 'EMP_STATUS_ID';
    const ID		                    = 'ID';
    const LID		                    = 'LID';
    const ORDER_TOPIC		            = 'ORDER_TOPIC';
    const PAY_SYSTEM_ID		            = 'PAY_SYSTEM_ID';
    const PAY_VOUCHER_DATE		        = 'PAY_VOUCHER_DATE';
    const PAY_VOUCHER_NUM		        = 'PAY_VOUCHER_NUM';
    const PAYED		                    = 'PAYED';
    const PERSON_TYPE_ID		        = 'PERSON_TYPE_ID';
    const PRICE		                    = 'PRICE';
    const REASON_MARKED		            = 'REASON_MARKED';
    const RESPONSIBLE_EMAIL		        = 'RESPONSIBLE_EMAIL';
    const RESPONSIBLE_ID		        = 'RESPONSIBLE_ID';
    const RESPONSIBLE_LAST_NAME		    = 'RESPONSIBLE_LAST_NAME';
    const RESPONSIBLE_LOGIN		        = 'RESPONSIBLE_LOGIN';
    const RESPONSIBLE_NAME		        = 'RESPONSIBLE_NAME';
    const RESPONSIBLE_PERSONAL_PHOTO    = 'RESPONSIBLE_PERSONAL_PHOTO';
    const RESPONSIBLE_SECOND_NAME		= 'RESPONSIBLE_SECOND_NAME';
    const RESPONSIBLE_WORK_POSITION		= 'RESPONSIBLE_WORK_POSITION';
    const STATUS_ID		                = 'STATUS_ID';
    const TAX_VALUE		                = 'TAX_VALUE';
    const COMPANY_ID		            = 'UF_COMPANY_ID';
    const CONTACT_ID		            = 'UF_CONTACT_ID';
    const DEAL_ID		                = 'UF_DEAL_ID';
    const USER_DESCRIPTION		        = 'USER_DESCRIPTION';
    const PR_LOCATION		            = 'PR_LOCATION';
    const INVOICE_PROPERTIES		    = 'INVOICE_PROPERTIES';
    const PRODUCT_ROWS		            = 'PRODUCT_ROWS';
}