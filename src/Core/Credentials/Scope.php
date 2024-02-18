<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;

class Scope
{
    /**
     * @var string[]
     */
    protected array $availableScope = [
        'bizproc',
        'biconnector',
        'calendar',
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
        'rpa',
        'sale',
        'salescenter',
        'smile',
        'socialnetwork',
        'sonet_group',
        'task',
        'tasks',
        'tasks_extended',
        'telephony',
        'timeman',
        'user',
        'user_basic',
        'user_brief',
        'user.userfield',
        'userconsent',
        'userfieldconfig',
    ];

    /**
     * @var array
     */
    protected array $currentScope = [];

    /**
     * Scope constructor.
     *
     * @param array $scope
     *
     * @throws UnknownScopeCodeException
     */
    public function __construct(array $scope = [])
    {
        $scope = array_unique(array_map('strtolower', $scope));

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

    /**
     * @return array
     */
    public function getScopeCodes(): array
    {
        return $this->currentScope;
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     */
    public static function initFromString(string $scope): self
    {
        return new self(str_replace(' ', '', explode(',', $scope)));
    }
}