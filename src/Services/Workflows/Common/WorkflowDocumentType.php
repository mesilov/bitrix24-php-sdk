<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Common;

enum WorkflowDocumentType: string
{
    // lead
    case crmLead = 'CCrmDocumentLead';
    // company
    case crmCompany = 'CCrmDocumentCompany';
    // contact
    case crmContact = 'CCrmDocumentContact';
    // deal
    case crmDeal = 'CCrmDocumentDeal';
    // drive file
    case discBizProcDocument = 'Bitrix\\Disk\\BizProcDocument';
    //  Drive file
    case listBizProcDocument = 'BizprocDocument';
    case listBizProcDocumentLists = 'BizprocDocumentLists';
    // smart process
    case smartProcessDynamic = 'Bitrix\\Crm\\Integration\\BizProc\\Document\\Dynamic';
    case task = 'Bitrix\\Tasks\\Integration\\Bizproc\\Document\\Task';
    case invoice = 'Bitrix\\Crm\\Integration\\BizProc\\Document\\SmartInvoice';
}
