<?php

namespace Bitrix24\SDK\Tests\Builders;

class DemoDataGenerator
{
    public static function getMobilePhone():string
    {
        return '+1-703-740-8301';
    }
    public static function getRecordFileUrl():string
    {
        return  'https://github.com/mesilov/bitrix24-php-sdk/raw/384-update-scope-telephony/tests/Integration/Services/Telephony/call-record-test.mp3';
    }
}