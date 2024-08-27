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

namespace Bitrix24\SDK\Core\Result;

use Bitrix24\SDK\Core\Response\Response;

/**
 * Class AbstractResult
 *
 * @package Bitrix24\SDK\Core\Result
 */
abstract class AbstractResult
{
    /**
     * AbstractResult constructor.
     */
    public function __construct(protected Response $coreResponse)
    {
    }

    public function getCoreResponse(): Response
    {
        return $this->coreResponse;
    }
}