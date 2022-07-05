<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Result\ExternalLineAddResult;


class ExternalLine extends AbstractService{
    /**
     * The method adds an outer line
     *
     * @param string $number
     * @param string $name
     *
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalLineAddResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://dev.1c-bitrix.ru/rest_help/scope_telephony/telephony/telephony_externalLine_add.php
     */

    public function add(string $number , string $name): ExternalLineAddResult
    {
        return new ExternalLineAddResult(
          $this->core->call(
              'telephony.externalLine.add',
              [
                  'NUMBER' => $number,
                  'NAME' => $name,
              ]
          )
        );
    }

    /**
     * The method adds an outer line
     *
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalLineAddResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://dev.1c-bitrix.ru/rest_help/scope_telephony/telephony/telephony_externalLine_get.php
     */

    public function get(): ExternalLineAddResult
    {
        return new ExternalLineAddResult(
          $this->core->call(
              'telephony.externalLine.get',
              [

              ]
          )
        );
    }
}