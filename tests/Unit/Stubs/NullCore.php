<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Stubs;

use Bitrix24\SDK\Core\ApiClient;
use Bitrix24\SDK\Core\Commands\Command;
use Bitrix24\SDK\Core\Contracts\ApiClientInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Response\Response;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * Class NullCore
 *
 * @package Bitrix24\SDK\Tests\Unit\Stubs
 */
class NullCore implements CoreInterface
{
    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return Response
     * @throws \Exception
     */
    public function call(string $apiMethod, array $parameters = []): Response
    {
        return new Response(new MockResponse(''), new Command('', []), new NullLogger());
    }

    public function getApiClient(): ApiClientInterface
    {
        return new ApiClient(Credentials::createForWebHook(new WebhookUrl('')), new MockHttpClient(), new NullLogger());
    }
}