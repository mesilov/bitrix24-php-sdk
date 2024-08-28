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

namespace Bitrix24\SDK\Services\Workflows\Workflow\Request;

use Bitrix24\SDK\Application\Requests\AbstractRequest;
use Bitrix24\SDK\Services\Workflows\Common\Auth;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowDocumentId;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowDocumentType;
use Symfony\Component\HttpFoundation\Request;

class IncomingWorkflowRequest extends AbstractRequest
{
    public function __construct(
        Request                              $request,
        readonly public string               $workflowId,
        readonly public string               $code,
        readonly public WorkflowDocumentId   $workflowDocumentId,
        readonly public WorkflowDocumentType $workflowDocumentType,
        readonly public string               $eventToken,
        readonly public array                $properties,
        readonly public bool                 $isUseSubscription,
        readonly public int                  $timeoutDuration,
        readonly public int                  $timestamp,
        readonly public Auth                 $auth
    )
    {
        parent::__construct($request);
    }

    public static function initFromRequest(Request $request): self
    {
        $data = $request->request->all();
        return new self(
            $request,
            (string)$data['workflow_id'],
            $data['code'],
            WorkflowDocumentId::initFromArray($data['document_id']),
            WorkflowDocumentType::initFromArray($data['document_type']),
            $data['event_token'],
            $data['properties'],
            $data['use_subscription'] === 'Y' ? true : false,
            (int)$data['timeout_duration'],
            (int)$data['ts'],
            Auth::initFromArray($data['auth'])
        );
    }
}