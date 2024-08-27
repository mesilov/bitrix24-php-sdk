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

namespace Bitrix24\SDK\Services\Placement;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Placement\Service\Placement;
use Bitrix24\SDK\Services\Placement\Service\UserFieldType;

class PlacementServiceBuilder extends AbstractServiceBuilder
{
    public function placement(): Placement
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Placement($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function userfieldtype(): UserFieldType
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new UserFieldType($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}