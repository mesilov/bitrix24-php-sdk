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

use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;
use PHPUnit\Framework\TestCase;

#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Core\Credentials\Scope::class)]
class ScopeTest extends TestCase
{
    /**
     * @throws UnknownScopeCodeException
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

        new Scope(['fooo']);
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public function testEqual(): void
    {
        $scope = Scope::initFromString('crm,telephony');
        $this->assertTrue($scope->equal(Scope::initFromString('telephony,crm')));
        $this->assertFalse($scope->equal(Scope::initFromString('telephony')));
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public function testEmptyScope(): void
    {
        $scope = new Scope(['']);
        $this->assertEquals([], $scope->getScopeCodes());
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public function testWrongScopeCode(): void
    {
        $scope = new Scope(['CRM', 'Call', 'im']);

        $this->assertEquals(['call', 'crm', 'im'], $scope->getScopeCodes());
    }

    /**
     * @throws UnknownScopeCodeException
     */
    #[\PHPUnit\Framework\Attributes\TestDox('Test init Scope from string')]
    public function testInitFromString(): void
    {
        $scopeList = ['crm', 'telephony', 'call', 'user_basic', 'placement', 'im', 'imopenlines'];
        sort($scopeList);
        $scope = Scope::initFromString('crm,telephony,call,user_basic,placement,im,imopenlines');
        $this->assertEquals($scopeList, $scope->getScopeCodes());
    }
}
