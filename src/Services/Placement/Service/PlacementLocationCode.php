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

namespace Bitrix24\SDK\Services\Placement\Service;

/**
 * @link https://training.bitrix24.com/rest_help/application_embedding/index.php
 */
class PlacementLocationCode
{
    // CRM scope
    public const CRM_LEAD_LIST_MENU = 'CRM_LEAD_LIST_MENU';

     // List menu for Leads
    public const CRM_LEAD_DETAIL_TAB = 'CRM_LEAD_DETAIL_TAB';

     // Upper menu item in the Lead details tab
    public const CRM_LEAD_DETAIL_ACTIVITY = 'CRM_LEAD_DETAIL_ACTIVITY';

     // Lead activity menu item
    public const CRM_DEAL_LIST_MENU = 'CRM_DEAL_LIST_MENU';

     //Deals list menu
    public const CRM_DEAL_DETAIL_TAB = 'CRM_DEAL_DETAIL_TAB';

      // Upper menu item in the Deals details
    public const CRM_DEAL_DETAIL_ACTIVITY = 'CRM_DEAL_DETAIL_ACTIVITY';

     // Deal activity menu item
    public const CRM_CONTACT_LIST_MENU = 'CRM_CONTACT_LIST_MENU';

     // Contact list menu
    public const CRM_CONTACT_DETAIL_TAB = 'CRM_CONTACT_DETAIL_TAB';

     // Upper menu item in the Contact details
    public const CRM_CONTACT_DETAIL_ACTIVITY = 'CRM_CONTACT_DETAIL_ACTIVITY';

     // Contact activity menu item
    public const CRM_COMPANY_LIST_MENU = 'CRM_COMPANY_LIST_MENU';

     // Company list menu
    public const CRM_COMPANY_DETAIL_TAB = 'CRM_COMPANY_DETAIL_TAB';

     // Upper menu item in the Company details
    public const CRM_COMPANY_DETAIL_ACTIVITY = 'CRM_COMPANY_DETAIL_ACTIVITY';

     // Company activity menu item
    public const CRM_INVOICE_LIST_MENU = 'CRM_INVOICE_LIST_MENU';

     // Invoices list menu
    public const CRM_QUOTE_LIST_MENU = 'CRM_QUOTE_LIST_MENU';

     // Quotes list context menu
    public const CRM_ACTIVITY_LIST_MENU = 'CRM_ACTIVITY_LIST_MENU';

     // Activities list context menu
    public const CRM_ANALYTICS_MENU = 'CRM_ANALYTICS_MENU';

     // CRM Analytics menu
    public const CRM_FUNNELS_TOOLBAR = 'CRM_FUNNELS_TOOLBAR';

    public const CRM_ANALYTICS_TOOLBAR = 'CRM_ANALYTICS_TOOLBAR';

    public const CRM_DEAL_LIST_TOOLBAR = 'CRM_DEAL_LIST_TOOLBAR';

     // Option in Automation Rules dropdown menu
    public const CRM_LEAD_LIST_TOOLBAR = 'CRM_LEAD_LIST_TOOLBAR';

     // Option in Automation Rules dropdown menu
    public const CRM_CONTACT_LIST_TOOLBAR = 'CRM_CONTACT_LIST_TOOLBAR';

     // Option in Automation Rules dropdown menu
    public const CRM_COMPANY_LIST_TOOLBAR = 'CRM_COMPANY_LIST_TOOLBAR';

     // Option in Automation Rules dropdown menu
    public const CRM_INVOICE_LIST_TOOLBAR = 'CRM_INVOICE_LIST_TOOLBAR';

     // Option in Automation Rules dropdown menu
    public const CRM_QUOTE_LIST_TOOLBAR = 'CRM_QUOTE_LIST_TOOLBAR';

     // Option in Automation Rules dropdown menu
    public const CRM_DEAL_DETAIL_TOOLBAR = 'CRM_DEAL_DETAIL_TOOLBAR';

     // Button at the upper section of CRM details.
    public const CRM_LEAD_DETAIL_TOOLBAR = 'CRM_LEAD_DETAIL_TOOLBAR';

     // Button at the upper section of CRM details.
    public const CRM_CONTACT_DETAIL_TOOLBAR = 'CRM_CONTACT_DETAIL_TOOLBAR';

     // Button at the upper section of CRM details.
    public const CRM_COMPANY_DETAIL_TOOLBAR = 'CRM_COMPANY_DETAIL_TOOLBAR';

     // Button at the upper section of CRM details.
    public const CRM_INVOICE_DETAIL_TOOLBAR = 'CRM_INVOICE_DETAIL_TOOLBAR';

     // Button at the upper section of CRM details.
    public const CRM_QUOTE_DETAIL_TOOLBAR = 'CRM_QUOTE_DETAIL_TOOLBAR';

     // Button at the upper section of CRM details.
    public const CRM_DEAL_ACTIVITY_TIMELINE_MENU = 'CRM_DEAL_ACTIVITY_TIMELINE_MENU';

     // Button in the object context menu
    public const CRM_LEAD_ACTIVITY_TIMELINE_MENU = 'CRM_LEAD_ACTIVITY_TIMELINE_MENU';

     // Button in the object context menu
    public const CRM_DEAL_DOCUMENTGENERATOR_BUTTON = 'CRM_DEAL_DOCUMENTGENERATOR_BUTTON';

     // Button in documents.
    public const CRM_LEAD_DOCUMENTGENERATOR_BUTTON = 'CRM_LEAD_DOCUMENTGENERATOR_BUTTON';

     // Button in documents.
    public const CRM_DEAL_ROBOT_DESIGNER_TOOLBAR = 'CRM_DEAL_ROBOT_DESIGNER_TOOLBAR';

        // Option in cogwheel dropdown menu with automation rules
    public const CRM_LEAD_ROBOT_DESIGNER_TOOLBAR = 'CRM_LEAD_ROBOT_DESIGNER_TOOLBAR';    // Option in cogwheel dropdown menu with automation rules

    public const TASK_USER_LIST_TOOLBAR = 'TASK_USER_LIST_TOOLBAR';

     // Option in Automation Rules dropdown menu. You must pass user ID in placement_options.
    public const TASK_GROUP_LIST_TOOLBAR = 'TASK_GROUP_LIST_TOOLBAR';

     // Option in Automation Rules dropdown menu. You must pass workgroup ID in placement_options.
    public const TASK_ROBOT_DESIGNER_TOOLBAR = 'TASK_ROBOT_DESIGNER_TOOLBAR';

     // Option in cogwheel dropdown menu with automation rule.
    public const SONET_GROUP_ROBOT_DESIGNER_TOOLBAR = 'SONET_GROUP_ROBOT_DESIGNER_TOOLBAR';

     // Option in Automation Rules dropdown menu in workgroup. You must pass current workgroup ID in placement_options.
    public const SONET_GROUP_TOOLBAR = 'SONET_GROUP_TOOLBAR';

     // Option in Automation Rules dropdown menu inside workgroup. You must pass current workgroup ID in placement_options идентификатор текущей группы.
    public const USER_PROFILE_MENU = 'USER_PROFILE_MENU';

     // Option with dropdown selection in the upper Bitrix24 account main menu. You must pass current user ID in placement_options.
    public const USER_PROFILE_TOOLBAR = 'USER_PROFILE_TOOLBAR';

     // Option in dropdown menu inside user profile. You must pass current user ID in placement_options.
    public const CRM_SMART_INVOICE_LIST_TOOLBAR = 'CRM_SMART_INVOICE_LIST_TOOLBAR';

    public const CRM_SMART_INVOICE_DETAIL_TOOLBAR = 'CRM_SMART_INVOICE_DETAIL_TOOLBAR';

    public const CRM_SMART_INVOICE_ACTIVITY_TIMELINE_MENU = 'CRM_SMART_INVOICE_ACTIVITY_TIMELINE_MENU';

    public const CRM_SMART_INVOICE_FUNNELS_TOOLBAR = 'CRM_SMART_INVOICE_FUNNELS_TOOLBAR';

    public const CRM_SMART_INVOICE_ROBOT_DESIGNER_TOOLBAR = 'CRM_SMART_INVOICE_ROBOT_DESIGNER_TOOLBAR';

    public const CRM_SMART_INVOICE_DETAIL_TAB = 'CRM_SMART_INVOICE_DETAIL_TAB';

    public const CRM_SMART_INVOICE_LIST_MENU = 'CRM_SMART_INVOICE_LIST_MENU';

    public const CRM_SMART_INVOICE_DETAIL_ACTIVITY = 'CRM_SMART_INVOICE_DETAIL_ACTIVITY';

    public const CRM_CONTACT_DOCUMENTGENERATOR_BUTTON = 'CRM_CONTACT_DOCUMENTGENERATOR_BUTTON';

    public const CRM_COMPANY_DOCUMENTGENERATOR_BUTTON = 'CRM_COMPANY_DOCUMENTGENERATOR_BUTTON';

    public const CRM_INVOICE_DOCUMENTGENERATOR_BUTTON = 'CRM_INVOICE_DOCUMENTGENERATOR_BUTTON';

    public const CRM_QUOTE_DOCUMENTGENERATOR_BUTTON = 'CRM_QUOTE_DOCUMENTGENERATOR_BUTTON';

    public const CRM_SMART_INVOICE_DOCUMENTGENERATOR_BUTTON = 'CRM_SMART_INVOICE_DOCUMENTGENERATOR_BUTTON';

    public const CRM_REQUISITE_EDIT_FORM = 'CRM_REQUISITE_EDIT_FORM';

    public const MAIN_1C_PAGE = '1C_PAGE';

    public const CRM_DETAIL_SEARCH = 'CRM_DETAIL_SEARCH';


    // ExternalLine scope
    public const CALL_CARD = 'CALL_CARD';

     // Call ID screen
    public const TELEPHONY_ANALYTICS_MENU = 'TELEPHONY_ANALYTICS_MENU';

    // Landing Scope
    public const LANDING_SETTINGS = 'LANDING_SETTINGS';

     // Settings menu (for Landing Page / Site)
    public const LANDING_BLOCK = 'LANDING_BLOCK'; // Edit option for any block.

    // Workgroups scope
    public const SONET_GROUP_DETAIL_TAB = 'SONET_GROUP_DETAIL_TAB'; // Workgroup detail tab.

    // scope task
    public const TASK_LIST_CONTEXT_MENU = 'TASK_LIST_CONTEXT_MENU';

     // Task list context menu.
    public const TASK_VIEW_TAB = 'TASK_VIEW_TAB';

     // New tab when viewing task
    public const TASK_VIEW_SIDEBAR = 'TASK_VIEW_SIDEBAR';

     // New side bar when viewing task
    public const TASK_VIEW_TOP_PANEL = 'TASK_VIEW_TOP_PANEL'; // Top panel when viewing task

    // Calendar scope
    public const CALENDAR_GRIDVIEW = 'CALENDAR_GRIDVIEW'; // List of calendar grid views

    // Contact_Center scope
    public const CONTACT_CENTER = 'CONTACT_CENTER'; // Square tile in the list of Contact Center.

    // Arbitrary location
    // This embedding does not have an UI button that user can use to manually open the app.
    // The app can send a link, leading to its embedding to any location (Instant Messenger, Feed and etc.).
    // To use this embedding option, the link must have the format /marketplace/view/#APP_CODE#/,
    // where #APP_CODE# - your app code.
    //
    // The embedding can receive any number of parameters in the "get" key params,
    // for example: /marketplace/view/#APP_CODE#/?params[test]=y.
    // The link can be embedded in any text field which supports BBCode or inside your other embedding locations as a standard link.
    // The GET parameter params can be used to modify the displayed parameters in the embedding.
    // You can use this option in any various scenarios by passing any number of parameters into GET key params,
    // for example: ?params[test]=yy.
    public const REST_APP_URI = 'REST_APP_URI';

    // Each account/portal allows for each individual application to register only a single embedding using the method placement.bind.
    // errorHandlerUrl - required field with error handler URL.
    // When the embedding upload takes a long period of time (longer than 3-5 seconds),
    // this URL receives a message with text and error code and the embedding itself is deleted.
    public const PAGE_BACKGROUND_WORKER = 'PAGE_BACKGROUND_WORKER';


    public function getForCrmDynamicListMenu(int $entityId): string
    {
        return sprintf('CRM_DYNAMIC_%s_LIST_MENU', $entityId);
    }


    public function getForCrmDynamicDetailTab(int $entityId): string
    {
        return sprintf('CRM_DYNAMIC_%s_DETAIL_TAB', $entityId);
    }


    public function getForCrmDynamicDetailActivity(int $entityId): string
    {
        return sprintf('CRM_DYNAMIC_%s_DETAIL_ACTIVITY', $entityId);
    }
}