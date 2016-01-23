<?php

namespace Bitrix24\Presets\CRM\Deal;

/**
 * Class Fields.
 */
class fields
{
    /**
     * @var string Deal ID. It is created automatically and is unique for the database,	can be read, can't write
     */
    const ID = 'ID';
    /**
     * @var string Deal name. A mandatory field, сan be read, can be write
     */
    const TITLE = 'TITLE';
    /**
     * @var string Deal type ID, сan be read, can be write
     */
    const TYPE_ID = 'TYPE_ID';
    /**
     * @var string Deal stage ID, сan be read, can be write
     */
    const STAGE_ID = 'STAGE_ID';
    /**
     * @var string Deal conclusion probability (in %) сan be read, can be write
     */
    const PROBABILITY = 'PROBABILITY';
    /**
     * @var string Deal currency сan be read, can be write
     */
    const CURRENCY_ID = 'CURRENCY_ID';
    /**
     * @var string Amount in deal currency, сan be read, can be write
     */
    const OPPORTUNITY = 'OPPORTUNITY';
    /**
     * @var string ID of a company that is a counterpart to the deal, сan be read, can be write
     */
    const COMPANY_ID = 'COMPANY_ID';
    /**
     * @var string Contact person ID, сan be read, can be write
     */
    const CONTACT_ID = 'CONTACT_ID';
    /**
     * @var string Deal opening date, сan be read, can be write
     */
    const BEGINDATE = 'BEGINDATE';
    /**
     * @var string Deal closing date,	сan be read, can be write
     */
    const CLOSEDATE = 'CLOSEDATE';
    /**
     * @var string Checkmark "Available to everyone", сan be read, can be write
     */
    const OPENED = 'OPENED';
    /**
     * @var string Checkmark "The deal is closed",	 сan be read, can be write
     */
    const CLOSED = 'CLOSED';
    /**
     * @var string Comments, сan be read, can be write
     */
    const COMMENTS = 'COMMENTS';
    /**
     * @var string Deal responsible’s ID, сan be read, can be write
     */
    const ASSIGNED_BY_ID = 'ASSIGNED_BY_ID';
    /**
     * @var string Deal creator’s ID, can be read, can't write
     */
    const CREATED_BY_ID = 'CREATED_BY_ID';
    /**
     * @var string ID of a person who modified the deal, can be read, can't write
     */
    const MODIFY_BY_ID = 'MODIFY_BY_ID';
    /**
     * @var string Creation date, can be read, can't write
     */
    const DATE_CREATE = 'DATE_CREATE';
    /**
     * @var string Modification date, can be read, can't write
     */
    const DATE_MODIFY = 'DATE_MODIFY';
    /**
     * @var string Lead ID	can be read, can't write
     */
    const LEAD_ID = 'LEAD_ID';
    /**
     * @var string Additional information, сan be read, can be write
     */
    const ADDITIONAL_INFO = 'ADDITIONAL_INFO';
    /**
     * @var string ID of the external information database. The field assignment can be modified by the end developer.	Can be read, can be write
     */
    const ORIGINATOR_ID = 'ORIGINATOR_ID';
    /**
     * @var string External key that is used for exchange operations. ID of an object of the external information database. The field assignment can be modified by the end developer.	Can be read, can be write
     */
    const ORIGIN_ID = 'ORIGIN_ID';
}
