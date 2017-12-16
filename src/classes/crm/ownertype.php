<?php
namespace Bitrix24\CRM;

/**
 * Class OwnerType
 * @package Bitrix24\CRM
 */
class OwnerType
{
    const Undefined = 0;

    const Lead = 1;    // refresh FirstOwnerType and LastOwnerType constants

    const Deal = 2;

    const Contact = 3;

    const Company = 4;

    const Invoice = 5;

    const Activity = 6;

    const Quote = 7;

    const Requisite = 8;

    const DealCategory = 9;

    const System = 10; // refresh FirstOwnerType and LastOwnerType constants

    const FirstOwnerType = 1;

    const LastOwnerType = 10;
}
