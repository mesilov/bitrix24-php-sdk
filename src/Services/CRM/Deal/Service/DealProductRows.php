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
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealProductRowItemsResult;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealResult;
use Money\Currency;

#[ApiServiceMetadata(new Scope(['crm']))]
class DealProductRows extends AbstractService
{
    /**
     * Returns products inside the specified deal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_productrows_get.php
     *
     * @param int $dealId
     * @param Currency|null $currency
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.productrows.get',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_productrows_get.php',
        'Returns products inside the specified deal.'
    )]
    public function get(int $dealId, Currency $currency = null): DealProductRowItemsResult
    {
        if ($currency === null) {
            $res = $this->core->call('batch', [
                'halt' => 0,
                'cmd' => [
                    'deal' => sprintf('crm.deal.get?ID=%s', $dealId),
                    'rows' => sprintf('crm.deal.productrows.get?ID=%s', $dealId)
                ],
            ]);
            $data = $res->getResponseData()->getResult();
            $currency = new Currency($data['result']['deal']['CURRENCY_ID']);
            return new DealProductRowItemsResult($res,$currency);
        }
        return new DealProductRowItemsResult(
            $this->core->call(
                'crm.deal.productrows.get',
                [
                    'id' => $dealId,
                ]
            ),
           $currency
        );
    }


    /**
     * Creates or updates product entries inside the specified deal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_productrows_set.php
     *
     * @param int $dealId
     * @param array<int, array{
     *   ID?: int,
     *   OWNER_ID?: int,
     *   OWNER_TYPE?: string,
     *   PRODUCT_ID?: int,
     *   PRODUCT_NAME?: string,
     *   PRICE?: string,
     *   PRICE_EXCLUSIVE?: string,
     *   PRICE_NETTO?: string,
     *   PRICE_BRUTTO?: string,
     *   QUANTITY?: string,
     *   DISCOUNT_TYPE_ID?: int,
     *   DISCOUNT_RATE?: string,
     *   DISCOUNT_SUM?: string,
     *   TAX_RATE?: string,
     *   TAX_INCLUDED?: string,
     *   CUSTOMIZED?: string,
     *   MEASURE_CODE?: int,
     *   MEASURE_NAME?: string,
     *   SORT?: int
     *   }> $productRows
     *
     * @return UpdatedItemResult
     * @throws BaseException
     * @throws TransportException
     */
    #[ApiEndpointMetadata(
        'crm.deal.productrows.set',
        'https://training.bitrix24.com/rest_help/crm/deals/crm_deal_productrows_set.php',
        'Creates or updates product entries inside the specified deal.'
    )]
    public function set(int $dealId, array $productRows): UpdatedItemResult
    {
        return new UpdatedItemResult(
            $this->core->call(
                'crm.deal.productrows.set',
                [
                    'id' => $dealId,
                    'rows' => $productRows,
                ]
            )
        );
    }
}