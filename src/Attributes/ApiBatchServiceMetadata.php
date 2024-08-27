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
use Bitrix24\SDK\Core\Credentials\Scope;

#[Attribute(Attribute::TARGET_CLASS)]
class ApiBatchServiceMetadata
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