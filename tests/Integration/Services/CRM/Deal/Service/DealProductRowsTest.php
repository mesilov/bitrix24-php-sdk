<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Deal\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Services\CRM\Deal\Service\DealProductRows;
use Bitrix24\SDK\Tests\Integration\Fabric;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use PHPUnit\Framework\TestCase;

/**
 * Class DealsTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Deals\Service
 */
class DealProductRowsTest extends TestCase
{
    protected Deal $dealService;
    protected DealProductRows $dealProductRowsService;

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealProductRows::set
     */
    public function testSet(): void
    {

        $callCosts = new Money(1050, new Currency('RUB'));
        $currencies = new ISOCurrencies();

        $moneyFormatter = new DecimalMoneyFormatter($currencies);
        $newDealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $this::assertCount(0, $this->dealProductRowsService->getSuperSmart($newDealId)->getProductRows());
        $this::assertTrue(
            $this->dealProductRowsService->set(
                $newDealId,
                [
                    [
                        'PRODUCT_NAME' => 'qqqq',
                        'PRICE'=> $moneyFormatter->format($callCosts),
                    ],
                ]
            )->isSuccess()
        );
        $this::assertCount(1, $this->dealProductRowsService->getSuperSmart($newDealId)->getProductRows());
        $mas = $this->dealProductRowsService->getSuperSmart($newDealId)->getProductRows()[0];
        $money =  $moneyFormatter->format($mas->PRICE);


    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testGet(): void
    {
        $callCosts = new Money(1050, new Currency('USD'));
        $currencies = new ISOCurrencies();

        $moneyFormatter = new DecimalMoneyFormatter($currencies);
        $newDealId = $this->dealService->add(['TITLE' => 'test deal','CURRENCY_ID'=>$callCosts->getCurrency()->getCode()])->getId();
        $this::assertTrue(
            $this->dealProductRowsService->set(
                $newDealId,
                [
                    [
                        'PRODUCT_NAME' => 'qqqq',
                        'PRICE'=> $moneyFormatter->format($callCosts),
                    ],
                ]
            )->isSuccess()
        );
        $currency = $callCosts->getCurrency();
        $res = $this->dealProductRowsService->getSuperSmart($newDealId);
        foreach ($res->getProductRows() as $productRow){
            var_dump($productRow->PRICE);
        }
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testBatch():void{
        $callCosts = new Money(1050, new Currency('EUR'));
        $currencies = new ISOCurrencies();

        $moneyFormatter = new DecimalMoneyFormatter($currencies);
        $newDealId = $this->dealService->add(['TITLE' => 'test deal','CURRENCY_ID'=>$callCosts->getCurrency()->getCode()])->getId();
        $this::assertTrue(
            $this->dealProductRowsService->set(
                $newDealId,
                [
                    [
                        'PRODUCT_NAME' => 'qqqq',
                        'PRICE'=> $moneyFormatter->format($callCosts),
                    ],
                ]
            )->isSuccess()
        );
     $data =   $this->core->call('batch',array(
            'halt'=>0,
            'cmd'=>array(
                'deal'=>'crm.deal.get?id='.$newDealId,
                'productrow'=>'crm.deal.productrows.get?ID=$result[deal]['.$newDealId.'][ID]',
            )
        ));
      print_r($data);
    }


    public function setUp(): void
    {
        $this->dealService = Fabric::getServiceBuilder()->getCRMScope()->deal();
        $this->dealProductRowsService = Fabric::getServiceBuilder()->getCRMScope()->dealProductRows();
        $this->core=Fabric::getCore();
    }
}