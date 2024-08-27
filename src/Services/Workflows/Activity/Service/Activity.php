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

namespace Bitrix24\SDK\Services\Workflows\Activity\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\DeletedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Workflows;
use Bitrix24\SDK\Services\Workflows\Activity\Result\AddedActivityResult;
use Bitrix24\SDK\Services\Workflows\Activity\Result\AddedMessageToLogResult;
use Bitrix24\SDK\Services\Workflows\Activity\Result\UpdateActivityResult;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowDocumentType;
use Psr\Log\LoggerInterface;
#[ApiServiceMetadata(new Scope(['bizproc']))]
class Activity extends AbstractService
{
    public function __construct(
        public Batch    $batch,
        CoreInterface   $core,
        LoggerInterface $log
    )
    {
        parent::__construct($core, $log);
    }

    /**
     * This method records data in the workflow log.
     * @return AddedMessageToLogResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_list.php
     */
    #[ApiEndpointMetadata(
        'bizproc.activity.log',
        'https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_list.php',
        'This method records data in the workflow log.'
    )]
    public function log(string $eventToken, string $message): Workflows\Activity\Result\AddedMessageToLogResult
    {
        return new Workflows\Activity\Result\AddedMessageToLogResult($this->core->call('bizproc.activity.log', [
            'EVENT_TOKEN' => $eventToken,
            'LOG_MESSAGE' => $message
        ]));
    }

    /**
     * This method returns list of activities, installed by the application.
     *
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_list.php
     */
    #[ApiEndpointMetadata(
        'bizproc.activity.list',
        'https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_list.php',
        'This method returns list of activities, installed by the application.'
    )]
    public function list(): Workflows\Activity\Result\WorkflowActivitiesResult
    {
        return new Workflows\Activity\Result\WorkflowActivitiesResult($this->core->call('bizproc.activity.list'));
    }

    /**
     * Adds new activity to a workflow.
     *
     * @param string $code Internal activity ID, unique within the application framework. Permissible symbols are a-z, A-Z, 0-9, period, hyphen and underscore.
     * @param string $handlerUrl URL, to which the activity will send data (via bitrix24 queue server), when workflow has reached its completion. Shall reference to the same domain, where the app is installed.
     * @param int $b24AuthUserId ID of the user, whose token will be passed to the application.
     * @param array $localizedName Name of activity, associative array of localized strings.
     * @param array $localizedDescription Description of activity, associative array of localized strings.
     * @param bool $isUseSubscription Use of subscription. It is possible to specify, whether the activity should or should not await for a response from the application. If the parameter is empty or not specified - user himself/herself can configure this parameter in settings of the activity in the workflows designer.
     * @param array $properties Array of activity parameters.
     * @param bool $isUsePlacement Enables option to open additional settings for activity in the app slider.
     * @param array $returnProperties Array of returned activity values.
     * @param WorkflowDocumentType $documentType Tip of document, which will determine type of data for parameters.
     * @param array $limitationFilter Activity limitation rules by document type and revision.
     *
     * @return AddedActivityResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_add.php
     */
    #[ApiEndpointMetadata(
        'bizproc.activity.add',
        'https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_add.php',
        'Adds new activity to a workflow.'
    )]
    public function add(
        string                                $code,
        string                                $handlerUrl,
        int                                   $b24AuthUserId,
        array                                 $localizedName,
        array                                 $localizedDescription,
        bool                                  $isUseSubscription,
        array                                 $properties,
        bool                                  $isUsePlacement,
        array                                 $returnProperties,
        Workflows\Common\WorkflowDocumentType $documentType,
        array                                 $limitationFilter,
    ): Workflows\Activity\Result\AddedActivityResult
    {
        return new Workflows\Activity\Result\AddedActivityResult($this->core->call('bizproc.activity.add', [
            'CODE' => $code,
            'HANDLER' => $handlerUrl,
            'AUTH_USER_ID' => $b24AuthUserId,
            'NAME' => $localizedName,
            'DESCRIPTION' => $localizedDescription,
            'USE_SUBSCRIPTION' => $isUseSubscription ? 'Y' : 'N',
            'PROPERTIES' => $properties,
            'USE_PLACEMENT' => $isUsePlacement ? 'Y' : 'N',
            'RETURN_PROPERTIES' => $returnProperties,
            'DOCUMENT_TYPE' => $documentType->toArray(),
            'FILTER' => $limitationFilter
        ]));
    }

    /**
     * This method deletes an activity.
     *
     * @return DeletedItemResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_delete.php
     */
    #[ApiEndpointMetadata(
        'bizproc.activity.delete',
        'https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_delete.php',
        'This method deletes an activity.'
    )]
    public function delete(string $activityCode): DeletedItemResult
    {
        return new DeletedItemResult(
            $this->core->call('bizproc.activity.delete', [
                'CODE' => $activityCode
            ]));
    }

    /**
     * This method allows to update activity fields. Method parameters are similar to bizproc.activity.add.
     *
     * @param string $code Internal activity ID, unique within the application framework. Permissible symbols are a-z, A-Z, 0-9, period, hyphen and underscore.
     * @param string|null $handlerUrl URL, to which the activity will send data (via bitrix24 queue server), when workflow has reached its completion. Shall reference to the same domain, where the app is installed.
     * @param int|null $b24AuthUserId ID of the user, whose token will be passed to the application.
     * @param array|null $localizedName Name of activity, associative array of localized strings.
     * @param array|null $localizedDescription Description of activity, associative array of localized strings.
     * @param bool|null $isUseSubscription Use of subscription. It is possible to specify, whether the activity should or should not await for a response from the application. If the parameter is empty or not specified - user himself/herself can configure this parameter in settings of the activity in the workflows designer.
     * @param array|null $properties Array of activity parameters.
     * @param bool|null $isUsePlacement Enables option to open additional settings for activity in the app slider.
     * @param array|null $returnProperties Array of returned activity values.
     * @param WorkflowDocumentType|null $documentType Tip of document, which will determine type of data for parameters.
     * @param array|null $limitationFilter Activity limitation rules by document type and revision.
     *
     * @return UpdateActivityResult
     * @throws BaseException
     * @throws TransportException
     * @see https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_update.php
     */
    #[ApiEndpointMetadata(
        'bizproc.activity.update',
        'https://training.bitrix24.com/rest_help/workflows/app_activities/bizproc_activity_update.php',
        'This method allows to update activity fields. Method parameters are similar to bizproc.activity.add.'
    )]
    public function update(
        string                                 $code,
        ?string                                $handlerUrl,
        ?int                                   $b24AuthUserId,
        ?array                                 $localizedName,
        ?array                                 $localizedDescription,
        ?bool                                  $isUseSubscription,
        ?array                                 $properties,
        ?bool                                  $isUsePlacement,
        ?array                                 $returnProperties,
        ?Workflows\Common\WorkflowDocumentType $documentType,
        ?array                                 $limitationFilter,
    ): Workflows\Activity\Result\UpdateActivityResult
    {
        $fieldsToUpdate = [];
        if ($handlerUrl !== null) {
            $fieldsToUpdate['HANDLER'] = $handlerUrl;
        }
        if ($b24AuthUserId !== null) {
            $fieldsToUpdate['AUTH_USER_ID'] = $b24AuthUserId;
        }
        if ($localizedName !== null) {
            $fieldsToUpdate['NAME'] = $localizedName;
        }
        if ($localizedDescription !== null) {
            $fieldsToUpdate['DESCRIPTION'] = $localizedDescription;
        }
        if ($isUseSubscription !== null) {
            $fieldsToUpdate['USE_SUBSCRIPTION'] = $isUseSubscription ? 'Y' : 'N';
        }
        if ($properties !== null) {
            $fieldsToUpdate['PROPERTIES'] = $properties;
        }
        if ($isUsePlacement !== null) {
            $fieldsToUpdate['USE_PLACEMENT'] = $isUsePlacement ? 'Y' : 'N';
        }
        if ($returnProperties !== null) {
            $fieldsToUpdate['RETURN_PROPERTIES'] = $returnProperties;
        }
        if ($documentType !== null) {
            $fieldsToUpdate['DOCUMENT_TYPE'] = $documentType->toArray();
        }
        if ($limitationFilter !== null) {
            $fieldsToUpdate['FILTER'] = $limitationFilter;
        }
        if (count($fieldsToUpdate) === 0) {
            throw new InvalidArgumentException('no fields to update – you must set minimum one field to update');
        }
        return new Workflows\Activity\Result\UpdateActivityResult($this->core->call(
            'bizproc.activity.update',
            [
                'CODE' => $code,
                'FIELDS' => $fieldsToUpdate
            ]));
    }
}
