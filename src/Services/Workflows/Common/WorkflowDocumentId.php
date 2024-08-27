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

namespace Bitrix24\SDK\Services\Workflows\Common;

readonly class WorkflowDocumentId
{
    public function __construct(
        public string $moduleId,
        public string $entityId,
        public string $targetDocumentId,
    )
    {
    }

    public function getId(): int
    {
        return (int)substr($this->targetDocumentId, 0, strpos('_', $this->targetDocumentId));
    }

    public static function initFromArray(array $data): WorkflowDocumentId
    {
        return new self($data[0], $data[1], $data[2]);
    }
}