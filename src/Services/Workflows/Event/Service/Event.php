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

namespace Bitrix24\SDK\Services\Workflows\Event\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Psr\Log\LoggerInterface;
#[ApiServiceMetadata(new Scope(['bizproc']))]
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
    #[ApiEndpointMetadata(
        'bizproc.event.send',
        'https://training.bitrix24.com/rest_help/workflows/workflows_events/bizproc_event_send.php',
        'returns output parameters to an activity. Parameters are specified in the activity description.'
    )]
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