<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Workflows;

class WorkflowsServiceBuilder extends AbstractServiceBuilder
{
    public function template(): Workflows\Template\Service\Template
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Workflows\Template\Service\Template(
                new Template\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}