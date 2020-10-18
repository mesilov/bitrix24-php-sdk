<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Core\Credentials;

use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use PHPUnit\Framework\TestCase;

/**
 * Class ScopeTest
 *
 * @package Bitrix24\SDK\Tests\Unit\Core
 */
class ScopeTest extends TestCase
{
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public function testBuildScopeFromArray(): void
    {
        $availableScope = [
            'bizproc',
            'calendar',
            'call',
            'contact_center',
            'crm',
            'delivery',
            'department',
            'disk',
            'documentgenerator',
            'entity',
            'faceid',
            'forum',
            'im',
            'imbot',
            'imopenlines',
            'intranet',
            'landing',
            'landing_cloud',
            'lists',
            'log',
            'mailservice',
            'messageservice',
            'mobile',
            'pay_system',
            'placement',
            'pull',
            'pull_channel',
            'rating',
            'sale',
            'smile',
            'sonet_group',
            'task',
            'tasks_extended',
            'telephony',
            'timeman',
            'user',
            'userconsent',
        ];
        $scope = new Scope($availableScope);
        $this->assertEquals($availableScope, $scope->getScopeCodes());
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public function testUnknownScope(): void
    {
        $this->expectException(UnknownScopeCodeException::class);

        $scope = new Scope(['fooo']);
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public function testWrongScopeCode(): void
    {
        $scope = new Scope(['CRM', 'Call', 'im']);

        $this->assertEquals(['crm', 'call', 'im'], $scope->getScopeCodes());
    }
}
