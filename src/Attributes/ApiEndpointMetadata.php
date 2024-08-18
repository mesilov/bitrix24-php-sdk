<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ApiEndpointMetadata
{
    public function __construct(
        public string  $name,
        public string  $documentationUrl,
        public ?string $description = null,
        public bool    $isDeprecated = false,
        public ?string $deprecationMessage = null
    )
    {
    }
}