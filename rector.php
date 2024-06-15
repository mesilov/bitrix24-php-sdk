<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\DowngradeLevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src/Services/Telephony',
        __DIR__ . '/tests/Integration/Services/Telephony',
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
        removeUnusedImports: true,
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