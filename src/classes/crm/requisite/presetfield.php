<?php

namespace Bitrix24\CRM\Requisite;

use Bitrix24\Bitrix24Entity;

class PresetField extends Bitrix24Entity
{
    /**
     * @param array $preset
     * @param array $fields array of fields
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_preset_field_add.php
     */
    public function add($preset = array(), $fields = array())
    {
        $fullResult = $this->client->call(
            'crm.requisite.preset.field.add',
            array(
                'preset' => $preset,
                'fields' => $fields,
            )
        );
        return $fullResult;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_preset_field_availabletoadd.php
     *
     * @param array $preset
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     */
    public function availableToAdd($preset = array())
    {
        $fullResult = $this->client->call(
            'crm.requisite.preset.field.availabletoadd',
            array(
                'preset' => $preset,
            )
        );
        return $fullResult;
    }

    /**
     * @link     https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_preset_field_delete.php
     *
     * @param $id
     *
     * @param $preset
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     * @internal param array $fields array of fields
     */
    public function delete($id, $preset)
    {
        $fullResult = $this->client->call(
            'crm.requisite.preset.field.delete',
            array(
                'id'     => $id,
                'preset' => $preset
            )
        );
        return $fullResult;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_preset_field_fields.php
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     */
    public function fields()
    {
        $fullResult = $this->client->call(
            'crm.requisite.preset.field.fields'
        );
        return $fullResult;
    }

    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_preset_field_get.php
     *
     * @param $id
     *
     * @param $preset
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     */
    public function get($id, $preset)
    {
        $fullResult = $this->client->call(
            'crm.requisite.preset.field.get',
            array(
                'id'     => $id,
                'preset' => $preset
            )
        );
        return $fullResult;
    }


    /**
     * Get list of requisite items.
     *
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_preset_field_list.php
     *
     *
     * @param array $preset
     * @param int   $start
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     */
    public function getList($preset = array(), $start = 0)
    {
        $fullResult = $this->client->call(
            'crm.requisite.preset.field.list',
            array(
                'preset' => $preset,
                'start'  => $start
            )
        );
        return $fullResult;
    }


    /**
     * @link https://dev.1c-bitrix.ru/rest_help/crm/requisite/methods/crm_requisite_preset_update.php
     *
     * @param       $id
     * @param array $fields      An array in format array("field"=>"value"[, ...]) containing values for the fields
     *                           that need to be updated. The fields can be one or more of those returned by
     *                           crm.requisite.preset.fields
     *
     * @return array
     * @throws \Bitrix24\Exceptions\Bitrix24WrongClientException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
     * @throws \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
     * @throws \Bitrix24\Exceptions\Bitrix24SecurityException
     * @throws \Bitrix24\Exceptions\Bitrix24PortalDeletedException
     * @throws \Bitrix24\Exceptions\Bitrix24PaymentRequiredException
     * @throws \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
     * @throws \Bitrix24\Exceptions\Bitrix24IoException
     * @throws \Bitrix24\Exceptions\Bitrix24Exception
     * @throws \Bitrix24\Exceptions\Bitrix24EmptyResponseException
     * @throws \Bitrix24\Exceptions\Bitrix24ApiException
     */
    public function update($preset = array(), $fields = array())
    {
        $fullResult = $this->client->call(
            'crm.requisite.preset.field.update',
            array(
                'preset' => $preset,
                'fields' => $fields
            )
        );
        return $fullResult;
    }
}
