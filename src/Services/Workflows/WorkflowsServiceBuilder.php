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

namespace Bitrix24\SDK\Services\Workflows;

use Bitrix24\SDK\Infrastructure\Filesystem\Base64Encoder;
use Bitrix24\SDK\Services\AbstractServiceBuilder;
use Bitrix24\SDK\Services\Workflows;
use Symfony\Component\Filesystem\Filesystem;

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

    public function activity(): Workflows\Activity\Service\Activity
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Workflows\Activity\Service\Activity(
                new Workflows\Activity\Service\Batch($this->batch, $this->log),
                $this->core,
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }

    public function task(): Workflows\Task\Service\Task
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Workflows\Task\Service\Task(
                new Workflows\Task\Service\Batch($this->batch, $this->log),
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
                new Base64Encoder(
                    new Filesystem(),
                    new \Symfony\Component\Mime\Encoder\Base64Encoder(),
                    $this->log,
                ),
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