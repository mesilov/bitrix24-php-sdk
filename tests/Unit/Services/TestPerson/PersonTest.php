<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services\TestPerson;

use Bitrix24\SDK\Services\CRM\Deal\Service\Deal;
use Bitrix24\SDK\Services\CRM\Product\Service\Product;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Money\Money;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\AggregateMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


class PersonTest extends TestCase
{
    protected Deal $deal;
    protected Product $product;
    /**
     * @test
     */
    public function SerializerTest():void{

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $person = new Person();
        $person->setName('Kirill');
        $person->setLastName('Khramov');



        $jsonContent = $serializer->serialize($person, 'json');


            self::assertNotEmpty($jsonContent);
        echo $jsonContent; // or return it in a Response
    }

    /**
     * @test
     */
    public function DeserializeTest():void{
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data = <<<EOF
        <Person>
            <name>Kirill</name>
            <lastname>Khramov</lastname>
            <sportsperson>false</sportsperson>
        </Person>
        EOF;

        $person = $serializer->deserialize($data, Person::class, 'xml');
      var_dump($person);
        self::assertNotEmpty($person);
    }

    /**
     * @test
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function NormalizeMoneyTest():void
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $dollars = new Money(100, new Currency('USD'));

        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $intlFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        $moneyFormatter = new AggregateMoneyFormatter([
            'USD' => $intlFormatter,
        ]);

        $money = $moneyFormatter->format($dollars);
        $jsonContent = $serializer->normalize($money, null, [AbstractNormalizer::ATTRIBUTES => ['amount']]);
        var_dump($jsonContent);
        self::assertNotEmpty($money);
    }

}