<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\MixedTest;

use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Services\CRM\Deal\Service\DealProductRows;
use Bitrix24\SDK\Services\CRM\Product\Service\Product;
use Monolog\Test\TestCase;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core\Exceptions\BaseException;


class MixedTest extends TestCase
{
    protected Deal $dealServices;
    protected Product $productService;
    protected DealProductRows $dealProductRows;

    /**
     * @test
     * @throws BaseException
     * @throws TransportException
     */
    public function DealWithProductsTest(): void
    {
        //Создание продукта 1
        $dataProduct1 = array(

                'NAME' => 'wine',
                'CURRENCY_ID' => 'USD',
                'PRICE' => 100,
                'SORT' => 1

        );
        $productId1 = $this->productService->add($dataProduct1)->getId();

        //Создание продукта 2
        $dataProduct2 = array(

                'NAME' => 'vodka',
                'CURRENCY_ID' => 'USD',
                'PRICE' => 10,
                'SORT' => 4

        );
        $productId2 = $this->productService->add($dataProduct2)->getId();


        //Создание Сделки
        $dataDeal1 = array(
            'TITLE' => 'sale of alcohol',
            'CURRENCY_ID' => 'RUB',
        );
        $dealId1 = $this->dealServices->add($dataDeal1)->getId();

        $productsForDeal = array(

                [
                    'PRODUCT_ID' => $productId1,
                    'PRICE' => 5000,
                    'QUANTITY' => 1
                ],
                [
                    'PRODUCT_ID' => $productId2,
                    'PRICE' => 500,
                    'QUANTITY' => 1
                ]

        );

        $addProductInDeal = $this->dealProductRows->set($dealId1, $productsForDeal);


        self::assertEquals($productsForDeal[0]['PRICE'],$this->dealProductRows->get($dealId1)->getCoreResponse()->getResponseData()->getResult()->getResultData()[0]['PRICE']);
        self::assertEquals($productsForDeal[1]['PRICE'],$this->dealProductRows->get($dealId1)->getCoreResponse()->getResponseData()->getResult()->getResultData()[1]['PRICE']);
        self::assertGreaterThanOrEqual(1, $productId1);
        self::assertGreaterThanOrEqual(1, $productId2);
        self::assertTrue((bool)$addProductInDeal);
    }


    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->productService = Fabric::getServiceBuilder()->getCRMScope()->product();
        $this->dealServices = Fabric::getServiceBuilder()->getCRMScope()->deal();
        $this->dealProductRows = Fabric::getServiceBuilder()->getCRMScope()->dealProductRows();
    }
}
