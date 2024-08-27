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

namespace Bitrix24\SDK\Tests\Unit\Core\Credentials;

use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
#[CoversClass(Credentials::class)]
class CredentialsTest extends TestCase
{
    #[Test]
    #[TestDox('tests get domain url')]
    #[DataProvider('credentialsDataProviderWithDomainUrlVariants')]
    public function testGetDomainUrl(
        Credentials $credentials,
        string $expectedDomainUrl
    ): void {
        $this->assertEquals($expectedDomainUrl, $credentials->getDomainUrl());
    }

    /**
     * @throws InvalidArgumentException
     * @throws UnknownScopeCodeException
     */
    #[Test]
    #[TestDox('tests get domain url without protocol')]
    public function testDomainUrlWithoutProtocol(): void
    {
        $credentials = Credentials::createFromOAuth(
            new AuthToken('', '', 0),
            new ApplicationProfile('', '', new Scope(['crm'])),
            'bitrix24-php-sdk-playground.bitrix24.ru'
        );
        $this->assertEquals(
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
            $credentials->getDomainUrl()
        );
    }

    #[Test]
    #[TestDox('tests isWebhookContext')]
    public function testIsWebhookContext():void
    {
        $credentials = Credentials::createFromOAuth(
            new AuthToken('', '', 0),
            new ApplicationProfile('', '', new Scope(['crm'])),
            'bitrix24-php-sdk-playground.bitrix24.ru'
        );
        $this->assertFalse($credentials->isWebhookContext());
    }

    /**
     * @throws InvalidArgumentException
     * @throws UnknownScopeCodeException
     */
    #[Test]
    #[TestDox('tests domain url with protocol')]
    public function testDomainUrlWithProtocol(): void
    {
        $credentials = Credentials::createFromOAuth(
            new AuthToken('', '', 0),
            new ApplicationProfile('', '', new Scope(['crm'])),
            'https://bitrix24-php-sdk-playground.bitrix24.ru'
        );
        $this->assertEquals(
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
            $credentials->getDomainUrl()
        );
    }

    /**
     * @throws InvalidArgumentException
     * @throws UnknownScopeCodeException
     */
    public static function credentialsDataProviderWithDomainUrlVariants(): Generator
    {
        yield 'with webhook walid domain url' => [
            Credentials::createFromWebhook(new WebhookUrl('https://bitrix24-php-sdk-playground.bitrix24.ru/rest/1/valid-webhook/')),
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
        ];
        yield 'with oauth domain url with end /' => [
            Credentials::createFromOAuth(
                new AuthToken('', '', 0),
                new ApplicationProfile('', '', new Scope(['crm'])),
                'https://bitrix24-php-sdk-playground.bitrix24.ru/'
            ),
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
        ];
        yield 'with oauth domain url without end /' => [
            Credentials::createFromOAuth(
                new AuthToken('', '', 0),
                new ApplicationProfile('', '', new Scope(['crm'])),
                'https://bitrix24-php-sdk-playground.bitrix24.ru'
            ),
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
        ];
    }
}
