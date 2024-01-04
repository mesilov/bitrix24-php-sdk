<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Builders\Services\CRM;

use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\Phone;
use Bitrix24\SDK\Services\CRM\Common\Result\SystemFields\Types\PhoneValueType;
use Exception;

class PhoneCollectionBuilder
{
    /**
     * @var Phone[]
     */
    private array $phones;
    private PhoneNumberBuilder $phoneNumberBuilder;

    public function __construct()
    {
        $this->phones = [];
        $this->phoneNumberBuilder = new PhoneNumberBuilder();
    }

    /**
     * @throws Exception
     */
    public function withDuplicatePhones(int $duplicatesCount = 1): self
    {
        $duplicatePhone = $this->phoneNumberBuilder->build();

        $duplicates = [];
        for ($i = 0; $i <= $duplicatesCount; $i++) {
            $duplicates[] = new Phone([
                'ID' => time() + random_int(1, 1000000),
                'VALUE' => $duplicatePhone,
                'VALUE_TYPE' => PhoneValueType::work->value
            ]);
        }

        $this->phones = array_merge(
            [
                new Phone([
                    'ID' => time() + random_int(1, 1000000),
                    'VALUE' => $this->phoneNumberBuilder->build(),
                    'VALUE_TYPE' => PhoneValueType::work->value
                ])
            ],
            $duplicates
        );

        return $this;
    }

    public function withPhoneLength(int $phoneLength): self
    {
        $this->phones = [
            new Phone([
                'ID' => time() + random_int(1, 1000000),
                'VALUE' => $this->phoneNumberBuilder->withLength($phoneLength)->build(),
                'VALUE_TYPE' => PhoneValueType::work->value
            ]),
            new Phone([
                'ID' => time() + random_int(1, 1000000),
                'VALUE' => $this->phoneNumberBuilder->withLength(7)->build(),
                'VALUE_TYPE' => PhoneValueType::work->value
            ])
        ];

        return $this;
    }

    /**
     * @throws Exception
     */
    public function build(): array
    {
        return $this->phones;
    }

    public function buildNewPhonesCommand(): array
    {
        $res = [];
        foreach ($this->phones as $phone) {
            $res[] = [
                'VALUE' => $phone->VALUE,
                'VALUE_TYPE' => $phone->VALUE_TYPE->value
            ];
        }
        return $res;
    }
}