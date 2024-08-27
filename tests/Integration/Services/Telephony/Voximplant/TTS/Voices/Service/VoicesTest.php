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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Voximplant\TTS\Voices\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\Telephony\Common\PbxType;
use Bitrix24\SDK\Services\Telephony\ExternalLine\Service\ExternalLine;
use Bitrix24\SDK\Services\Telephony\Voximplant\Sip\Service\Sip;
use Bitrix24\SDK\Services\Telephony\Voximplant\TTS\Voices\Service\Voices;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Voices::class)]
class VoicesTest extends TestCase
{
    private Voices $voices;

    /**
     * @throws TransportException
     * @throws BaseException
     */
    #[Test]
    #[TestDox('test list available voices for generation of speech')]
    public function testGet(): void
    {
        $voximplantVoicesResult = $this->voices->get();
        $this->assertGreaterThanOrEqual(1, count($voximplantVoicesResult->getVoices()));
    }

    protected function setUp(): void
    {
        $this->voices = Fabric::getServiceBuilder()->getTelephonyScope()->getVoximplantServiceBuilder()->ttsVoices();
    }
}