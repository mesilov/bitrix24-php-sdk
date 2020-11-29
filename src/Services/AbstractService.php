<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Core\Core;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractService
 *
 * @package Bitrix24\SDK\Services
 */
abstract class AbstractService
{
    /**
     * @var Core
     */
    protected $core;
    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * AbstractService constructor.
     *
     * @param Core            $core
     * @param LoggerInterface $log
     */
    public function __construct(Core $core, LoggerInterface $log)
    {
        $this->core = $core;
        $this->log = $log;
    }
}