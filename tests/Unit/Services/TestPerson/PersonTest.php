<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services\TestPerson;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class PersonTest extends TestCase
{
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
}