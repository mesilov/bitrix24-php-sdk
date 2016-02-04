<?php
namespace Bitrix24\CRM;
use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;

class Contact extends Bitrix24Entity
{
	/**
	 * Get list of contact items.
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_list.php
	 * @param array $order - order of task items
	 * @param array $filter - filter array
	 * @param array $select - array of collumns to select
	 * @param integer $start - entity number to start from (usually returned in 'next' field of previous 'crm.contact.list' API call)
	 * @return array
	 * @throws Bitrix24Exception
	 *
	 */
	public function getList($order = array(), $filter = array(), $select = array(), $start = 0)
	{
		$fullResult = $this->client->call(
			'crm.contact.list',
			array(
				'order' => $order,
				'filter'=> $filter,
				'select'=> $select,
				'start'	=> $start
			)
		);
		return $fullResult;
	}

    /**
     * Add a new contact to CRM
     * @param array $fields array of fields
     * @param array $params array of params
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_add.php
     * @return array
     */
	public function add($fields = array(), $params = array())
	{
		$fullResult = $this->client->call(
			'crm.contact.add',
			array(
                'fields' => $fields,
                'params' => $params
            )
		);
		return $fullResult;
	}

	/**
	 * Get contact by identifier
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_get.php
	 * @param integer $bitrix24UserId contact identifier
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function get($bitrix24UserId)
	{
		$fullResult = $this->client->call(
			'crm.contact.get',
			array('id' => $bitrix24UserId)
		);
		return $fullResult;
	}

	/**
	 * Deletes the specified contact
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_delete.php
	 * @param integer $bitrix24UserId contact identifier
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function delete($bitrix24UserId)
	{
		$fullResult = $this->client->call(
			'crm.contact.delete',
			array('id' => $bitrix24UserId)
		);
		return $fullResult;
	}

	/**
	 * get list of contact fields with description
	 * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_fields.php
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function fields()
	{
		$fullResult = $this->client->call(
			'crm.contact.fields'
		);
		return $fullResult;
	}

    /**
     * @link http://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_update.php
     * @param integer $contactId Specifies the contact ID
     * @param array $fields An array in format array("field"=>"value"[, ...]) containing values for the fields that need to be updated.
     * The fields can be one or more of those returned by crm.contact.fields.
     * @param array $params Set of parameters. REGISTER_SONET_EVENT - performs registration of a change event in a contact in the Activity Stream.
     * The contact's Responsible person will also receive notification.
     * @return array
     */
    public function update($contactId, $fields = array(), $params = array())
    {
        $fullResult = $this->client->call(
            'crm.contact.update',
            array(
                'id' => $contactId,
                'fields' => $fields,
                'params' => $params
            )
        );
        return $fullResult;
    }
}
