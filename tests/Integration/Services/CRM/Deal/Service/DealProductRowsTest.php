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

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Deal\Service;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\CRM\Common\Result\DiscountType;
use Bitrix24\SDK\Services\CRM\Deal\Result\DealProductRowItemResult;
use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Services\CRM\Deal\Service\DealProductRows;
use Bitrix24\SDK\Tests\Builders\DemoDataGenerator;
use Bitrix24\SDK\Tests\Integration\Fabric;
use MoneyPHP\Percentage\Percentage;
use PHPUnit\Framework\TestCase;
use Typhoon\Reflection\TyphoonReflector;

class DealProductRowsTest extends TestCase
{
    private Deal $dealService;
    private DealProductRows $dealProductRowsService;
    private DecimalMoneyFormatter $decimalMoneyFormatter;
    private TyphoonReflector $typhoonReflector;

    public function testAllSystemPropertiesAnnotated(): void
    {
        $dealId = $this->dealService->add(['TITLE' => 'test deal'])->getId();
        $this->dealProductRowsService->set(
            $dealId,
            [
                [
                    'PRODUCT_NAME' => sprintf('product name %s', time()),
                    'PRICE' => $this->decimalMoneyFormatter->format(new Money(100000, DemoDataGenerator::getCurrency())),
                ],
            ]
        );
        // get response from server with actual keys
        $propListFromApi = array_keys($this->dealProductRowsService->get($dealId)->getCoreResponse()->getResponseData()->getResult()['result']['rows'][0]);
        // parse keys from phpdoc annotation
        $props = $this->typhoonReflector->reflectClass(DealProductRowItemResult::class)->properties();
        $propsFromAnnotations = [];
        foreach ($props as $meta) {
            if ($meta->isAnnotated() && !$meta->isNative()) {
                $propsFromAnnotations[] = $meta->id->name;
            }
        }

        $this->assertEquals($propListFromApi, $propsFromAnnotations,
            sprintf('in phpdocs annotations for class %s cant find fields from actual api response: %s',
                DealProductRowItemResult::class,
                implode(', ', array_values(array_diff($propListFromApi, $propsFromAnnotations)))
            ));
    }

    /**
     * @throws BaseException
     * @throws TransportException
     * @covers \Bitrix24\SDK\Services\CRM\Deal\Service\DealProductRows::set
     */
    public function testSet(): void
    {
        $dealId = $this->dealService->add(['TITLE' => sprintf('test deal %s', time())])->getId();
        $deal = $this->dealService->get($dealId)->deal();
        $price = new Money(100000, $deal->CURRENCY_ID);
        $discount = new Money(50012, $deal->CURRENCY_ID);
        $this::assertTrue(
            $this->dealProductRowsService->set(
                $dealId,
                [
                    [
                        'PRODUCT_NAME' => sprintf('product name %s', time()),
                        'PRICE' => $this->decimalMoneyFormatter->format($price),
                        'DISCOUNT_TYPE_ID' => 1,
                        'DISCOUNT_SUM' => $this->decimalMoneyFormatter->format($discount)
                    ],
                ]
            )->isSuccess()
        );
        $productRows = $this->dealProductRowsService->get($dealId);
        $this->assertCount(1, $productRows->getProductRows());
        $productRow = $productRows->getProductRows()[0];
        $this->assertEquals($price, $productRow->PRICE);
        $this->assertEquals(DiscountType::monetary, $productRow->DISCOUNT_TYPE_ID);
        $this->assertEquals($discount, $productRow->DISCOUNT_SUM);
        $discount = $discount->multiply(100)->divide($this->decimalMoneyFormatter->format($price->add($discount)));
        $calculatedPercentage = new Percentage((string)((int)$discount->getAmount() / 100));
        $this->assertEquals($calculatedPercentage, $productRow->DISCOUNT_RATE);
    }

    public function testGet(): void
    {
        $dealId = $this->dealService->add(['TITLE' => sprintf('test deal %s', time())])->getId();
        $deal = $this->dealService->get($dealId)->deal();
        $price = new Money(100000, $deal->CURRENCY_ID);
        $discount = new Money(0, $deal->CURRENCY_ID);
        $this::assertTrue(
            $this->dealProductRowsService->set(
                $dealId,
                [
                    [
                        'PRODUCT_NAME' => sprintf('product name %s', time()),
                        'PRICE' => $this->decimalMoneyFormatter->format($price),
                    ],
                ]
            )->isSuccess()
        );
        $productRows = $this->dealProductRowsService->get($dealId);
        $this->assertCount(1, $productRows->getProductRows());
        $productRow = $productRows->getProductRows()[0];
        $this->assertEquals($price, $productRow->PRICE);
        $this->assertEquals(DiscountType::percentage, $productRow->DISCOUNT_TYPE_ID);
        $this->assertEquals($discount, $productRow->DISCOUNT_SUM);
        $this->assertEquals(Percentage::zero(), $productRow->DISCOUNT_RATE);
    }

    public function setUp(): void
    {
        $this->dealService = Fabric::getServiceBuilder()->getCRMScope()->deal();
        $this->dealProductRowsService = Fabric::getServiceBuilder()->getCRMScope()->dealProductRows();
        $this->decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        $this->typhoonReflector = TyphoonReflector::build();
    }
}