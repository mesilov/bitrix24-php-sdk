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

namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Voximplant\Url\Service;

use Bitrix24\SDK\Services\Telephony\Voximplant\Url\Service\Url;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Url::class)]
class UrlTest extends TestCase
{
    private Url $url;

    #[Test]
    #[TestDox('Method tests returns a set of links for browsing telephony scope pages.')]
    public function testDeactivatePhone(): void
    {
        $this->assertEquals(
            parse_url($this->url->core->getApiClient()->getCredentials()->getDomainUrl(), PHP_URL_HOST),
            parse_url($this->url->get()->getPages()->detail_statistics, PHP_URL_HOST),
        );
    }

    protected function setUp(): void
    {
        $this->url = Fabric::getServiceBuilder(true)->getTelephonyScope()->getVoximplantServiceBuilder()->url();
    }
}