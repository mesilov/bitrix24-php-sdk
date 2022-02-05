<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Credentials;

use Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException;

/**
 * Class Scope
 *
 * @package Bitrix24\SDK\Core\Credentials
 */
class Scope
{
    /**
     * @var string[]
     */
    protected array $availableScope = [
        'app',
        'bizproc',
        'calendar',
        'call',
        'catalog',
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
        foreach ($scope as $item) {
            if (!in_array($item, $this->availableScope, true)) {
                throw new UnknownScopeCodeException(sprintf('unknown application scope code - %s', $item));
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
}