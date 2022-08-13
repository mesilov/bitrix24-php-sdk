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

        $callCosts = new Money(1000, new Currency('RUB'));
        $currencies = new ISOCurrencies();

        $moneyFormatter = new DecimalMoneyFormatter($currencies);
        $newDealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $this::assertCount(0, $this->dealProductRowsService->get($newDealId)->getProductRows());
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
        $this::assertCount(1, $this->dealProductRowsService->get($newDealId)->getProductRows());
        $mas = $this->dealProductRowsService->get($newDealId)->getProductRows()[0];
        var_dump($mas);
        $price =  $mas->PRICE;
        var_dump($price);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealProductRows::get
     */
    public function testGet(): void
    {
        $newDealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $this::assertCount(0, $this->dealProductRowsService->get($newDealId)->getProductRows());
        $this::assertTrue(
            $this->dealProductRowsService->set(
                $newDealId,
                [
                    [
                        'PRODUCT_NAME' => 'qqqq',
                    ],
                ]
            )->isSuccess()
        );
        $this::assertCount(1, $this->dealProductRowsService->get($newDealId)->getProductRows());
    }

    public function setUp(): void
    {
        $this->dealService = Fabric::getServiceBuilder()->getCRMScope()->deal();
        $this->dealProductRowsService = Fabric::getServiceBuilder()->getCRMScope()->dealProductRows();
    }
}