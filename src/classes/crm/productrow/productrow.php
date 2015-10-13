<?php
namespace Bitrix24\CRM;
use Bitrix24\Bitrix24Entity;

class ProductRow extends Bitrix24Entity
{

    /**
     * Get list of ProductRow items.
     * @link http://dev.1c-bitrix.ru/rest_help/crm/productrow/crm_productrow_list.php
     * @param string $ownerType - OWNER_TYPE owner entity type single character code ("D" - Deal, "L" - Lead)
     * @param integer $ownerId - OWNER_ID owner entity ID
     * @return array
     */
    public function getList($ownerType, $ownerId, $start = 0)
    {
        $fullResult = $this->client->call(
	    'crm.productrow.list',
            array(
                'order' => array(),
                'filter'=> array(
	                'OWNER_TYPE'=> $ownerType,
        	        'OWNER_ID'=> $ownerId,
		),
                'select'=> array(),
		'start' => $start
            )
        );
        return $fullResult;
    }


    /**
     * get fields descriptions
     * @link http://dev.1c-bitrix.ru/rest_help/crm/productrow/crm_productrow_fields.php
     * @return array
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.productrow.fields',
            array()
        );
        return $fullResult;
    }

}


