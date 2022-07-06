<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Result\ExternalLineAddResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalLinesResult;


class ExternalLine extends AbstractService{
    /**
     * The method adds an outer line
     *
     * @param string $lineNumber
     * @param string $nameLine
     *
     * @return \Bitrix24\SDK\Services\Telephony\Result\ExternalLineAddResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_add.php
     */

    public function add(string $lineNumber , string $nameLine): ExternalLineAddResult
    {
        return new ExternalLineAddResult(
          $this->core->call(
              'telephony.externalLine.add',
              [
                  'NUMBER' => $lineNumber,
                  'NAME' => $nameLine,
              ]
          )
        );
    }

    /**
     * The method adds an outer line
     *
     * @return ExternalLinesResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_get.php
     */

    public function get(): ExternalLinesResult
    {
        return new ExternalLinesResult(
          $this->core->call(
              'telephony.externalLine.get',
              [

              ]
          )
        );
    }
}