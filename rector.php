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

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\DowngradeLevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src/Core/',
        __DIR__ . '/src/Application/',
        __DIR__ . '/src/Services/Telephony',
        __DIR__ . '/tests/Integration/Services/Telephony',
        __DIR__ . '/src/Services/Catalog',
        __DIR__ . '/tests/Integration/Services/Catalog',
        __DIR__ . '/src/Services/User',
        __DIR__ . '/tests/Integration/Services/User',
        __DIR__ . '/src/Services/UserConsent',
        __DIR__ . '/tests/Integration/Services/UserConsent',
        __DIR__ . '/src/Services/IM',
        __DIR__ . '/tests/Integration/Services/IM',
        __DIR__ . '/src/Services/IMOpenLines',
        __DIR__ . '/tests/Integration/Services/IMOpenLines',
        __DIR__ . '/src/Services/Main',
        __DIR__ . '/tests/Integration/Services/Main',
        __DIR__ . '/src/Services/Placement',
        __DIR__ . '/tests/Integration/Services/Placement',
        __DIR__ . '/tests/Unit/',
    ])
    ->withCache(cacheDirectory: __DIR__ . '.cache/rector')
    ->withSets(
        [
            DowngradeLevelSetList::DOWN_TO_PHP_82,
            PHPUnitSetList::PHPUNIT_100
        ]
    )
    ->withImportNames(
        importNames: false,
        importDocBlockNames: false,
        importShortClasses: false,
        removeUnusedImports: false,
    )
    ->withPhpSets(
        php82: true   // 8.2
    )
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        strictBooleans: true
    )
    ->withSkip([
        RenamePropertyToMatchTypeRector::class
    ]);