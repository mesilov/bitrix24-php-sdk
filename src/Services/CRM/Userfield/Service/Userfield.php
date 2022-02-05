<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Userfield\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\FieldsResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Userfield\Result\UserfieldTypesResult;

class Userfield extends AbstractService
{
    /**
     * Returns list of user field types.
     *
     * @link https://training.bitrix24.com/rest_help/crm/userfields/crm_userfield_types.php
     * @return UserfieldTypesResult
     * @throws BaseException
     * @throws TransportException
     */
    public function types(): UserfieldTypesResult
    {
        return new UserfieldTypesResult($this->core->call('crm.userfield.types'));
    }

    /**
     * Returns field description for user fields.
     *
     * @link https://training.bitrix24.com/rest_help/crm/userfields/crm_userfield_fields.php
     * @return \Bitrix24\SDK\Core\Result\FieldsResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function fields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.userfield.fields'));
    }

    /**
     * Returns field description for "enumeration" user field type (list).
     *
     * @link https://training.bitrix24.com/rest_help/crm/userfields/crm_userfield_enumeration_fields.php
     * @return \Bitrix24\SDK\Core\Result\FieldsResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function enumerationFields(): FieldsResult
    {
        return new FieldsResult($this->core->call('crm.userfield.enumeration.fields'));
    }

    /**
     * Returns settings field description for user field type.
     *
     * @link https://training.bitrix24.com/rest_help/crm/userfields/crm_userfield_settings_fields.php
     *
     * @param string $userfieldTypeId
     *
     * @return \Bitrix24\SDK\Core\Result\FieldsResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function settingsFields(string $userfieldTypeId): FieldsResult
    {
        return new FieldsResult(
            $this->core->call('crm.userfield.settings.fields', [
                'type' => $userfieldTypeId,
            ])
        );
    }
}