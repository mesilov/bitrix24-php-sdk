<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Core\Credentials;

use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Generator;
use PHPUnit\Framework\TestCase;

class CredentialsTest extends TestCase
{
    /**
     * @dataProvider credentialsDataProviderWithDomainUrlVariants
     *
     * @param \Bitrix24\SDK\Core\Credentials\Credentials $credentials
     * @param                                            $expectedDomainUrl
     *
     * @return void
     */
    public function testGetDomainUrl(
        Credentials $credentials,
        $expectedDomainUrl
    ): void {
        $this->assertEquals($expectedDomainUrl, $credentials->getDomainUrl());
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public function testDomainUrlWithoutProtocol(): void
    {
        $credentials = Credentials::createFromOAuth(
            new AccessToken('', '', 0),
            new ApplicationProfile('', '', new Scope(['crm'])),
            'bitrix24-php-sdk-playground.bitrix24.ru'
        );
        $this->assertEquals(
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
            $credentials->getDomainUrl()
        );
    }

    /**
     * @return void
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public function testDomainUrlWithProtocol(): void
    {
        $credentials = Credentials::createFromOAuth(
            new AccessToken('', '', 0),
            new ApplicationProfile('', '', new Scope(['crm'])),
            'https://bitrix24-php-sdk-playground.bitrix24.ru'
        );
        $this->assertEquals(
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
            $credentials->getDomainUrl()
        );
    }

    /**
     * @return \Generator
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public static function credentialsDataProviderWithDomainUrlVariants(): Generator
    {
        yield 'with webhook walid domain url' => [
            Credentials::createFromWebhook(new WebhookUrl('https://bitrix24-php-sdk-playground.bitrix24.ru/rest/1/valid-webhook/')),
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
        ];
        yield 'with oauth domain url with end /' => [
            Credentials::createFromOAuth(
                new AccessToken('', '', 0),
                new ApplicationProfile('', '', new Scope(['crm'])),
                'https://bitrix24-php-sdk-playground.bitrix24.ru/'
            ),
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
        ];
        yield 'with oauth domain url without end /' => [
            Credentials::createFromOAuth(
                new AccessToken('', '', 0),
                new ApplicationProfile('', '', new Scope(['crm'])),
                'https://bitrix24-php-sdk-playground.bitrix24.ru'
            ),
            'https://bitrix24-php-sdk-playground.bitrix24.ru',
        ];
    }
}
