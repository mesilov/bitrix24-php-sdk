<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Voximplant;

use Bitrix24\SDK\Infrastructure\Filesystem\Base64Encoder;
use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Telephony;
use Symfony\Component\Filesystem\Filesystem;

class VoximplantServiceBuilder extends AbstractServiceBuilder
{
    public function sip(): Telephony\Voximplant\Sip\Service\Sip
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Telephony\Voximplant\Sip\Service\Sip(
                new Telephony\Voximplant\Sip\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function user(): Telephony\Voximplant\User\Service\User
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Telephony\Voximplant\User\Service\User(
                new Telephony\Voximplant\User\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function infoCall(): Telephony\Voximplant\InfoCall\Service\InfoCall
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Telephony\Voximplant\InfoCall\Service\InfoCall(
                new Telephony\Voximplant\InfoCall\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function ttsVoices(): Telephony\Voximplant\TTS\Voices\Service\Voices
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Telephony\Voximplant\TTS\Voices\Service\Voices(
                new Telephony\Voximplant\TTS\Voices\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function line(): Telephony\Voximplant\Line\Service\Line
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Telephony\Voximplant\Line\Service\Line(
                new Telephony\Voximplant\Line\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function url(): Telephony\Voximplant\Url\Service\Url
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Telephony\Voximplant\Url\Service\Url(
                new Telephony\Voximplant\Url\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}