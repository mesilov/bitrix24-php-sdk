<?php
namespace Bitrix24\CRM\Lead;
use Bitrix24\Bitrix24Entity;

/**
 * Class UserField
 */
class UserField extends Bitrix24Entity
{
	/**
	 * Get list of user fields items.
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_userfield_list.php
	 * @param array $order - order of task items
	 * @param array $filter - filter array
	 * @return array
	 */
	public function getList($order = array(), $filter = array())
	{
		$fullResult = $this->client->call(
			'crm.lead.userfield.list',
			array(
				'order' => $order,
				'filter'=> $filter
			)
		);
		return $fullResult;
	}

	/**
	 * Get item userfield
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_userfield_get.php
	 * @param integer $userfieldId - lead userfield id
	 * @return array
	 */
	public function get($userfieldId)
	{
		$fullResult = $this->client->call(
			'crm.lead.userfield.get',
			array('id' => $userfieldId)
		);
		return $fullResult;
	}

	/**
	 * delete userfield
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_userfield_delete.php
	 * @param integer $userfieldId - lead userfield id
	 * @return array
	 */
	public function delete($userfieldId)
	{
		$fullResult = $this->client->call(
			'crm.lead.userfield.delete',
			array('id' => $userfieldId)
		);
		return $fullResult;
	}

	/**
	 * get list of lead userfield fields with description
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_userfield_fields.php
	 * @return array
	 */
	public function fields()
	{
		$fullResult = $this->client->call(
			'crm.userfield.fields'
		);
		return $fullResult;
	}

	/**
	 * Add a new userfield to lead
	 * @param array $fields array of fields
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_userfield_add.php
	 * @return array
	 */
	public function add($fields = array())
	{
		$fullResult = $this->client->call(
			'crm.lead.userfield.add',
			array('fields' => $fields)
		);
		return $fullResult;
	}

    /**
     * Updates userfield
     *
     * @param       $id
     * @param array $fields
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_userfield_update.php
     * @return array
     */
    public function update($id, $fields = array())
    {
        $fullResult = $this->client->call(
            'crm.lead.userfield.update',
            array(
                'id'     => $id,
                'fields' => $fields
            )
        );

        return $fullResult;
    }
}