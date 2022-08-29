<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Result\UpdatedItemResult;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealProductRowItemsResult;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealResult;
use Money\Currency;

/**
 * Class DealProductRows
 *
 * @package Bitrix24\SDK\Services\CRM\Deals\Service
 */
class DealProductRows extends AbstractService
{
    /**
     * Returns products inside the specified deal.
     *
     * @link https://training.bitrix24.com/rest_help/crm/deals/crm_deal_productrows_get.php
     *
     * @param int $dealId
     * @param \Money\Currency $currency
     * @return DealProductRowItemsResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function getStupid(int $dealId, Currency $currency): DealProductRowItemsResult
    {
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
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getSmart(int $dealId): DealProductRowItemsResult
    {
        $deal = new DealResult($this->core->call('crm.deal.get', ['id' => $dealId]));
        $currency = new Currency($deal->deal()->CURRENCY_ID);
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
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getSuperSmart(int $dealId): DealProductRowItemsResult
    {
        $res =  $this->core->call('batch',[
            'halt'=>0,
            'cmd'=>[
                $deal =  new DealResult( $this->core->call('crm.deal.get', ['id' => $dealId])),
                $rows = new DealProductRowItemsResult($this->core->call('crm.deal.productrows.get',['id' => $dealId,]),new Currency($deal->deal()->CURRENCY_ID)),

            ],
        ]);
        return $rows;
       /*$data  = $res->getResponseData()->getResult();
       $array = $data->getResultData()['result']['deal']['CURRENCY_ID'];
        var_dump($array);
        return new DealProductRowItemsResult(
            $data->getResultData()['result']['deal']['ID'] ,
           new Currency($array)
        );*/
        // todo Получить сделку и табличную часть за один запрос к Api
    }

    public function getSuperSuperSmart()
    {
        // todo Метод позволяет экономить один запрос если мы уже знаем валюту, а если не знаем то делает этот запрос.
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