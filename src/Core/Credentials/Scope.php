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

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;

class Scope
{
    /**
     * @var string[]
     */
    protected array $availableScope = [
        'ai_admin',
        'appform',
        'baas',
        'bizproc',
        'biconnector',
        'calendar',
        'calendarmobile',
        'catalogmobile',
        'call',
        'cashbox',
        'catalog',
        'configuration.import',
        'contact_center',
        'crm',
        'delivery',
        'department',
        'disk',
        'documentgenerator',
        'entity',
        'faceid',
        'forum',
        'iblock',
        'im',
        'imbot',
        'imopenlines',
        'im.import',
        'imconnector',
        'intranet',
        'landing',
        'landing_cloud',
        'lists',
        'log',
        'mailservice',
        'messageservice',
        'mobile',
        'notifications',
        'pay_system',
        'placement',
        'pull',
        'pull_channel',
        'rating',
        'rpa',
        'sale',
        'salescenter',
        'smile',
        'socialnetwork',
        'sonet_group',
        'task',
        'tasks',
        'tasks_extended',
        'tasksmobile',
        'telephony',
        'timeman',
        'user',
        'user_basic',
        'user_brief',
        'user.userfield',
        'userconsent',
        'userfieldconfig',
    ];

    protected array $currentScope = [];

    /**
     * Scope constructor.
     *
     *
     * @throws UnknownScopeCodeException
     */
    public function __construct(array $scope = [])
    {
        $scope = array_unique(array_map(strtolower(...), $scope));
        sort($scope);
        if (count($scope) === 1 && $scope[0] === '') {
            $scope = [];
        } else {
            foreach ($scope as $item) {
                if (!in_array($item, $this->availableScope, true)) {
                    throw new UnknownScopeCodeException(sprintf('unknown application scope code - %s', $item));
                }
            }
        }

        $this->currentScope = $scope;
    }

    public function equal(self $scope): bool
    {
        return $this->currentScope === $scope->getScopeCodes();
    }

    public function getScopeCodes(): array
    {
        return $this->currentScope;
    }

    /**
     * @throws UnknownScopeCodeException
     */
    public static function initFromString(string $scope): self
    {
        return new self(str_replace(' ', '', explode(',', $scope)));
    }
}