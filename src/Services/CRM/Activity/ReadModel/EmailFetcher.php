<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity\ReadModel;

use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Services\CRM\Activity\Result\Email\EmailActivityItemResult;
use Generator;

class EmailFetcher
{
    private BulkItemsReaderInterface $bulkItemsReader;

    /**
     * @param \Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface $bulkItemsReader
     */
    public function __construct(BulkItemsReaderInterface $bulkItemsReader)
    {
        $this->bulkItemsReader = $bulkItemsReader;
    }

    /**
     * @param array    $order
     * @param array    $filter
     * @param array    $select
     * @param int|null $limit
     *
     * @return EmailActivityItemResult[]|Generator
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getList(array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $filter = array_merge($filter, [
            'PROVIDER_ID'      => 'CRM_EMAIL',
            'PROVIDER_TYPE_ID' => 'EMAIL',
        ]);

        foreach ($this->bulkItemsReader->getTraversableList('crm.activity.list', $order, $filter, $select, $limit) as $cnt => $item) {
            yield $cnt => new EmailActivityItemResult($item);
        }
    }
}