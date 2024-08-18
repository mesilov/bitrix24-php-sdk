<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Attributes;

use Attribute;
use Bitrix24\SDK\Core\Credentials\Scope;

#[Attribute(Attribute::TARGET_CLASS)]
class ApiServiceMetadata
{
    public function __construct(
        public Scope   $scope,
        public ?string $documentationUrl = null,
        public ?string $description = null,
        public bool    $isDeprecated = false,
        public ?string $deprecationMessage = null
    )
    {
    }
}