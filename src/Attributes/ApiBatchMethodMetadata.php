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

namespace Bitrix24\SDK\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ApiBatchMethodMetadata
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