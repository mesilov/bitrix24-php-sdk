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

namespace Bitrix24\SDK\Services\CRM\Activity\ReadModel;

use Bitrix24\SDK\Attributes\ApiBatchMethodMetadata;
use Bitrix24\SDK\Attributes\ApiBatchServiceMetadata;
use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Services\CRM\Activity\Result\Email\EmailActivityItemResult;
use Generator;

#[ApiBatchServiceMetadata(new Scope(['crm']))]
class EmailFetcher
{
    private BulkItemsReaderInterface $bulkItemsReader;

    /**
     * @param BulkItemsReaderInterface $bulkItemsReader
     */
    public function __construct(BulkItemsReaderInterface $bulkItemsReader)
    {
        $this->bulkItemsReader = $bulkItemsReader;
    }

    /**
     * @return Generator<positive-int, EmailActivityItemResult>
     * @throws BaseException
     */
    #[ApiBatchMethodMetadata(
        'crm.activity.list',
        'https://training.bitrix24.com/rest_help/crm/rest_activity/crm_activity_list.php',
        'Returns in batch mode a list of activity where provider id is an a EMAIL'
    )]
    public function getList(array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $filter = array_merge($filter, [
            'PROVIDER_ID' => 'CRM_EMAIL',
            'PROVIDER_TYPE_ID' => 'EMAIL',
        ]);

        foreach ($this->bulkItemsReader->getTraversableList('crm.activity.list', $order, $filter, $select, $limit) as $cnt => $item) {
            yield $cnt => new EmailActivityItemResult($item);
        }
    }
}