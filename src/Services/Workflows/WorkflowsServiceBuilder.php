<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows;

use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Workflows;

class WorkflowsServiceBuilder extends AbstractServiceBuilder
{
    public function event(): Workflows\Event\Service\Event
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Workflows\Event\Service\Event(
                new Workflows\Event\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function robot(): Workflows\Robot\Service\Robot
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Workflows\Robot\Service\Robot(
                new Workflows\Template\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function template(): Workflows\Template\Service\Template
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Workflows\Template\Service\Template(
                new Workflows\Template\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function workflow(): Workflows\Workflow\Service\Workflow
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Workflows\Workflow\Service\Workflow(
                new Workflows\Workflow\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}