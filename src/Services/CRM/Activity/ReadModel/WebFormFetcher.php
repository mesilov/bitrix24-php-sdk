<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity\ReadModel;

use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Services\CRM\Activity\Result\WebForm\WebFormActivityItemResult;
use Generator;

class WebFormFetcher
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
     * @param int|null $webFormId
     * @param int|null $limit
     *
     * @return WebFormActivityItemResult[]|Generator
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getList(array $order, array $filter, array $select, ?int $webFormId = null, ?int $limit = null): Generator
    {
        if ($webFormId !== null) {
            $filter = array_merge($filter, [
                'PROVIDER_ID'      => 'CRM_WEBFORM',
                'PROVIDER_TYPE_ID' => $webFormId,
            ]);
        } else {
            $filter = array_merge($filter, ['PROVIDER_ID' => 'CRM_WEBFORM']);
        }
        foreach ($this->bulkItemsReader->getTraversableList('crm.activity.list', $order, $filter, $select, $limit) as $cnt => $item) {
            yield $cnt => new WebFormActivityItemResult($item);
        }
    }
}