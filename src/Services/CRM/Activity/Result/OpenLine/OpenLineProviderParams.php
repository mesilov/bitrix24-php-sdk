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

namespace Bitrix24\SDK\Services\CRM\Activity\Result\OpenLine;

class OpenLineProviderParams
{
    private string $userCode;

    /**
     * @param string $userCode
     */
    public function __construct(string $userCode)
    {
        $this->userCode = $userCode;
    }

    /**
     * @return string
     */
    public function getUserCode(): string
    {
        return $this->userCode;
    }

    /**
     * @return int
     */
    public function getBitrix24UserId(): int
    {
        return (int)explode('|', $this->getUserCode())[3];
    }

    /**
     * @return string
     */
    public function getExternalSystemUserId(): string
    {
        return explode('|', $this->getUserCode())[2];
    }
}