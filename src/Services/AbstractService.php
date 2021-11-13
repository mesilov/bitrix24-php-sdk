<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractService
 *
 * @package Bitrix24\SDK\Services
 */
abstract class AbstractService
{
    /**
     * @property-read CoreInterface $core
     */
    public CoreInterface $core;
    protected LoggerInterface $log;

    /**
     * AbstractService constructor.
     *
     * @param CoreInterface   $core
     * @param LoggerInterface $log
     */
    public function __construct(CoreInterface $core, LoggerInterface $log)
    {
        $this->core = $core;
        $this->log = $log;
    }
}