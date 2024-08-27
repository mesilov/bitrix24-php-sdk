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

namespace Bitrix24\SDK\Services\Workflows\Common;

enum DocumentType: string
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
