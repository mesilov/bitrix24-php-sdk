<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\DowngradeLevelSetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src/Services/Workflows',
        __DIR__ . '/tests/Integration/Services/Telephony',
    ])
    ->withSets(
        [
            DowngradeLevelSetList::DOWN_TO_PHP_82,
            PHPUnitSetList::PHPUNIT_100
        ]
    )
    ->withPhpSets(
        php82: true   // 8.2
    )
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ]);