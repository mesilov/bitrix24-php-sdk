<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\MixedTest;

use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Services\CRM\Product\Service\Product;
use Monolog\Test\TestCase;
use Bitrix24\SDK\Tests\Integration\Fabric;
use http;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;

class MixedTest extends TestCase
{
    protected Deal $dealServices;
    protected Product $productService;

    /**
     * @test
     * @throws \JsonException
     */
    public function DealWithProductsTest(): void
    {
        //Создание продукта 1
        $dataProduct1 = array(
            'fields' => array(
                'NAME' => '1С-Битрикс: Управление сайтом - Старт',
                'CURRENCY_ID' => 'RUB',
                'PRICE' => 4900,
                'SORT' => 4
            )
        );
        $queryDataForProduct1 = http_build_query($dataProduct1, 'https://b24-5p29et.bitrix24.ru/rest/1/113n4wi2ocu6rme0/crm.product.add') . PHP_EOL;
        $resQueryForProduct1 = file_get_contents("https://b24-5p29et.bitrix24.ru/rest/1/113n4wi2ocu6rme0/crm.product.add?" . $queryDataForProduct1);
        $decodeResQueryForProduct1 = json_decode($resQueryForProduct1, true, 512, JSON_THROW_ON_ERROR);
        $idForProduct1 = $decodeResQueryForProduct1['result'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $resQueryForProduct1,
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        //Создание продукта 2
        $dataProduct2 = array(
            'fields' => array(
                'NAME' => '1С-Битрикс: Управление сайтом - Старт 2 ',
                'CURRENCY_ID' => 'USD',
                'PRICE' => 4500,
                'SORT' => 1,
            )
        );
        $queryDataForProduct2 = http_build_query($dataProduct2, 'https://b24-5p29et.bitrix24.ru/rest/1/113n4wi2ocu6rme0/crm.product.add') . PHP_EOL;
        $resQueryForProduct2 = file_get_contents("https://b24-5p29et.bitrix24.ru/rest/1/113n4wi2ocu6rme0/crm.product.add?" . $queryDataForProduct2);
        $decodeResQueryForProduct2 = json_decode($resQueryForProduct2, true, 512, JSON_THROW_ON_ERROR);
        $idForProduct2 = $decodeResQueryForProduct2['result'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $resQueryForProduct2,
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        //Создание Сделки
        $dataDeal1 = array(
            'fields' => array(
                'TITLE' => 'test deal',
                'CURRENCY_ID' => 'USD',
                'OPPORTUNITY' => 500
            )
        );
        $queryDataForDeal1 = http_build_query($dataDeal1, 'https://b24-5p29et.bitrix24.ru/rest/1/113n4wi2ocu6rme0/crm.deal.add') . PHP_EOL;
        $resQueryForDeal1 = file_get_contents("https://b24-5p29et.bitrix24.ru/rest/1/113n4wi2ocu6rme0/crm.deal.add?" . $queryDataForProduct1);
        $decodeResQueryForDeal1 = json_decode($resQueryForDeal1, true, 512, JSON_THROW_ON_ERROR);
        $idForDeal1 = $decodeResQueryForDeal1['result'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $resQueryForDeal1,
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        //Добавление продукта в сделку
        $addProductInDeal = array(
            'id' => $idForDeal1,
            'rows' => array(
                [
                    'PRODUCT_ID' => $idForProduct1,
                    'PRICE' => 100,
                ],
                [
                    'PRODUCT_ID' => $idForProduct2,
                    'PRICE' => 100,
                ]
            )
        );
        $queryDataForProductInDeal = http_build_query($addProductInDeal, 'https://b24-5p29et.bitrix24.ru/rest/1/113n4wi2ocu6rme0/crm.deal.productrows.set') . PHP_EOL;
        $resQueryForProductInDeal = file_get_contents("https://b24-5p29et.bitrix24.ru/rest/1/113n4wi2ocu6rme0/crm.deal.productrows.set?" . $queryDataForProductInDeal);
        $decodeResQueryForDeal1 = json_decode($resQueryForProductInDeal, true, 512, JSON_THROW_ON_ERROR);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $resQueryForProductInDeal,
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        self::assertNotEmpty($dataProduct1);
        self::assertNotEmpty($dataProduct2);
        self::assertNotEmpty($dataDeal1);
        self::assertNotEmpty($addProductInDeal);
    }


    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function setUp(): void
    {
        $this->productService = Fabric::getServiceBuilder()->getCRMScope()->product();
        $this->dealServices = Fabric::getServiceBuilder()->getCRMScope()->deal();
    }
}
