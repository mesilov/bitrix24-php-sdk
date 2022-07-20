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

namespace Bitrix24\SDK\Services\Telephony;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Telephony\Service\Call;
use Bitrix24\SDK\Services\Telephony\Service\ExternalLine;
use Bitrix24\SDK\Services\Telephony\Service\ExternalCall;


class TelephonyServiceBuilder extends AbstractServiceBuilder
{
    /**
     * @return ExternalLine
     */
    public function externalLine(): ExternalLine
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new ExternalLine($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return ExternalCall
     */
    public function externalCall(): ExternalCall
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new ExternalCall($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    /**
     * @return Call
     */
    public function call(): Call
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Call($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

}