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

namespace Bitrix24\SDK\Application\Contracts\ContactPersons\Entity;

use Stringable;

class FullName implements Stringable
{
    public function __construct(
        public string  $name,
        public ?string $surname = null,
        public ?string $patronymic = null
    )
    {
        if ($surname !== null) {
            $this->surname = trim($surname);
        }

        if ($this->patronymic !== null) {
            $this->patronymic = trim((string) $patronymic);
        }
    }

    public function equal(self $fullName): bool
    {
        return $this->name === $fullName->name && $this->surname === $fullName->surname && $this->patronymic === $fullName->patronymic;
    }

    public function __toString(): string
    {
        return sprintf('%s %s %s', $this->name, $this->surname, $this->patronymic);
    }
}