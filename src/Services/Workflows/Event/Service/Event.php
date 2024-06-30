<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Workflows\Event\Service;

use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Psr\Log\LoggerInterface;

class Event extends AbstractService
{
    public function __construct(
        public Batch           $batch,
        CoreInterface   $core,
        LoggerInterface $log
    )
    {
        parent::__construct($core, $log);
    }

    /**
     * returns output parameters to an activity. Parameters are specified in the activity description.
     *
     * @return Workflows\Event\Result\EventSendResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/workflows_events/bizproc_event_send.php
     */
    public function send(
        string  $eventToken,
        array   $returnValues,
        ?string $logMessage = null,
    ): Workflows\Event\Result\EventSendResult
    {
        return new Workflows\Event\Result\EventSendResult($this->core->call(
            'bizproc.event.send',
            [
                'event_token' => $eventToken,
                'return_values' => $returnValues,
                'log_message' => $logMessage
            ]
        ));
    }
}