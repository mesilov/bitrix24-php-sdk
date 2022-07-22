<?php

declare(strict_types=1);

/*
 * This file is part of the bitrix24-php-sdk package.
 *
 *  Kirill  Кhramov <k_hram@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Services\Telephony\Service;

use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Telephony\Result\ExternalLineAddResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalLinesResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalLineDeleteResult;
use Bitrix24\SDK\Services\Telephony\Result\ExternalLineUpdateResult;


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
            $this->core->call('telephony.externalLine.get')
        );
    }

    /**
     * The method allows you to change the name of the external line
     *
     * @param string $lineNumber
     * @param string $newLineName
     *
     * @return ExternalLineUpdateResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_update.php
     */

    public function update(string $lineNumber, string $newLineName): ExternalLineUpdateResult
    {
        return new ExternalLineUpdateResult(
            $this->core->call('telephony.externalLine.update',
                [
                    'NUMBER' => $lineNumber,
                    'NAME' => $newLineName,
                ]
            )
        );
    }

    /**
     * The method for removing an external line.
     *
     * @param string $lineNumber
     *
     * @return ExternalLineDeleteResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_delete.php
     */

    public function delete(string $lineNumber): ExternalLineDeleteResult
    {
        return new ExternalLineDeleteResult(
            $this->core->call('telephony.externalLine.delete',
                [
                    'NUMBER' => $lineNumber,
                ]
            )
        );
    }
}