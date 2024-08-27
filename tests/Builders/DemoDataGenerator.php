<?php
declare(strict_types=1);

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Tests\Builders;

use Bitrix24\SDK\Application\Contracts\ContactPersons\Entity\FullName;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Darsyn\IP\Version\Multi;
use Faker;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use Money\Currency;
use Money\Money;
use Random\RandomException;

class DemoDataGenerator
{
    /**
     * @throws InvalidArgumentException|NumberParseException
     */
    public static function getMobilePhone(): PhoneNumber
    {
        $num = PhoneNumberUtil::getInstance()->parse(Faker\Factory::create()->phoneNumber(), 'US');
        if ($num === null) {
            throw new InvalidArgumentException('cannot parse phone number');
        }
        return $num;
    }

    public static function getRecordFileUrl(): string
    {
        return 'https://github.com/mesilov/bitrix24-php-sdk/raw/384-update-scope-telephony/tests/Integration/Services/Telephony/call-record-test.mp3';
    }

    public static function getFullName(): FullName
    {
        $faker = Faker\Factory::create();
        return new FullName($faker->lastName(), $faker->lastName(), $faker->lastName());
    }

    public static function getEmail(): string
    {
        return Faker\Factory::create()->email();
    }

    public static function getUserAgent(): string
    {
        return Faker\Factory::create()->userAgent();
    }

    public static function getUserAgentIp(): Multi
    {
        return Multi::factory(Faker\Factory::create()->ipv4());
    }

    public static function getCurrency(): Currency
    {
        return new Currency('USD');
    }

    /**
     * @throws RandomException
     */
    public static function getMoneyAmount(): Money
    {
        return new Money(random_int(1000, 1000000), self::getCurrency());
    }
}