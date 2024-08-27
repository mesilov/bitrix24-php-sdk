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

namespace Bitrix24\SDK\Tests\Builders\Services\CRM;

use Exception;

class PhoneNumberBuilder
{
    private int $length;

    public function __construct()
    {
        $this->length = 7;
    }

    public function withLength(int $length): self
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function build(): string
    {
        return '+1' . substr((string)time(), 2, $this->length) . substr((string)random_int(1000, PHP_INT_MAX), 0, 3);
    }
}