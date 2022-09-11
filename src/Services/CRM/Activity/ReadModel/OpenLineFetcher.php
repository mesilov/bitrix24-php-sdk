<?php


declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Activity\ReadModel;

use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Services\CRM\Activity\Result\OpenLine\OpenLineActivityItemResult;
use Generator;

class OpenLineFetcher
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
     * @param int|null $openLineTypeId
     * @param int|null $limit
     *
     * @return OpenLineActivityItemResult[]|Generator
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getList(array $order, array $filter, array $select, ?int $openLineTypeId = null, ?int $limit = null): Generator
    {
        if ($openLineTypeId !== null) {
            $filter = array_merge($filter, [
                'PROVIDER_ID'      => 'IMOPENLINES_SESSION',
                'PROVIDER_TYPE_ID' => $openLineTypeId,
            ]);
        } else {
            $filter = array_merge($filter, ['PROVIDER_ID' => 'IMOPENLINES_SESSION']);
        }

        foreach ($this->bulkItemsReader->getTraversableList('crm.activity.list', $order, $filter, $select, $limit) as $cnt => $item) {
            yield $cnt => new OpenLineActivityItemResult($item);
        }
    }
}