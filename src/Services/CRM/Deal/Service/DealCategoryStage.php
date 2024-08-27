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

namespace Bitrix24\SDK\Services\CRM\Deal\Service;

use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealCategoryStagesResult;

#[ApiServiceMetadata(new Scope(['crm']))]
class DealCategoryStage extends AbstractService
{
    /**
     * @param int $categoryId Category ID. When ID = 0 or null is specified , returns "default" category statuses. When ID > 0 for nonexistent category , returns nothing.
     *
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.dealcategory.stage.list',
        'https://training.bitrix24.com/rest_help/crm/category/crm_dealcategory_stage_list.php',
        'Returns list of deal stages for category by the ID. Equivalent to calling crm.status.list method with parameter ENTITY_ID equal to the result of calling crm.dealcategory.status method.'
    )]
    public function list(int $categoryId): DealCategoryStagesResult
    {
        return new DealCategoryStagesResult(
            $this->core->call(
                'crm.dealcategory.stage.list',
                [
                    'id' => $categoryId,
                ]
            )
        );
    }
}