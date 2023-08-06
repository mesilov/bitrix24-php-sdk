<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Core;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Tests\Integration\Fabric;
use DateTime;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Class OperatingTimingTest
 *
 * @package Bitrix24\SDK\Tests\Integration\OperatingTimingTest
 */
class OperatingTimingTest extends TestCase
{
    protected Contact $contactService;
    protected Batch $batch;

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testOperatingTiming(): void
    {
        // С версии модуля Rest 22.0.0 в облачной версии Битрикс24 во всех ответах rest запросов в массиве time с
        // дополнительной информацией о времени выполнения запроса добавлен дополнительный ключ operating, который
        // говорит о времени выполнения запроса к методу конкретным приложением. Данные о времени выполнения запросов к
        // методу суммируются. При превышении времени выполнения запросов сверх 480 секунд в рамках прошедших 10 минут
        // данный метод блокируется для приложения. При этом все остальные методы продолжают работать.
        // Ключ operating_reset_at возвращает timestamp в которое будет высвобождена часть лимита на данный метод.

        //example:
        //911 |operating   74.438894271851  |cur_time  2023-04-15 16:56:46 |op_reset_at 1681567606    →   2023-04-15 14:06:46
        //912 |operating   74.438894271851  |cur_time  2023-04-15 16:56:46 |op_reset_at 1681567606    →   2023-04-15 14:06:46
        //913 |operating   74.438894271851  |cur_time  2023-04-15 16:56:47 |op_reset_at 1681567606    →   2023-04-15 14:06:46
        //...
        //1509 |operating   104.5405356884  |cur_time  2023-04-15 16:57:21 |op_reset_at 1681567640    →   2023-04-15 14:07:20
        //1510 |operating   104.5405356884  |cur_time  2023-04-15 16:57:21 |op_reset_at 1681567640    →   2023-04-15 14:07:20


//        $contactsToUpdate = $this->getContactsUpdateCommand(15000);
//
//
//        //todo считать количество контактов для обновления и считать количество контактов которые обновили, если не совпало, то падаем с ошибкой
//
//        // обновляем контакты в батч-режиме
//        $cnt = 0;
//        foreach ($this->contactService->batch->update($contactsToUpdate) as $b24ContactId => $contactUpdateResult) {
//            $cnt++;
//
//            $debugOperatingLog = sprintf(
//                    'cnt    %s |id %s |operating   %s  |cur_time  %s |op_reset_at %s    →   %s',
//                    $cnt,
//                    $b24ContactId,
//                    $contactUpdateResult->getResponseData()->getTime()->getOperating(),
//                    $contactUpdateResult->getResponseData()->getTime()->getDateFinish()->format('Y-m-d H:i:s'),
//                    $contactUpdateResult->getResponseData()->getTime()->getOperatingResetAt(),
//                    (new DateTime)->setTimestamp($contactUpdateResult->getResponseData()->getTime()->getOperatingResetAt())->format('Y-m-d H:i:s')
//                ) . PHP_EOL;
//            file_put_contents('operating.log', $debugOperatingLog);
//        }
//
//        $this->assertEquals(
//            count($contactsToUpdate),
//            $cnt,
//            sprintf('updated contacts count %s not equal to expected %s cmd items', $cnt, count($contactsToUpdate))
//        );

        // шаг 1 - выброс корректного исключения, что мол упали из за блокировки метода
        // проблемы: - можно потерять часть данных при обновлении, т.к. мы не знаем, какие контакты в клиентском коде обновились, а какие нет или знаем?

// todo уточнение, по возможности возвращать в исключении остаток данных, которые не успели обновиться

//[2023-04-15T14:17:57.881428+00:00] integration-test.INFO: getResponseData.responseBody {"responseBody":
//{"result":
//{
//      "result":[],
//      "result_error":
//      {
//          "592dcd1e-cd14-410f-bab5-76b3ede717dd":
//          {
//              "error":"OPERATION_TIME_LIMIT",
//              "error_description":"Method is blocked due to operation time limit."
//          }
//    },
//   "result_total":[],
//   "result_next":[],
//   "result_time":[]},
//   "time":{
//          "start":1681568278.071253,
//          "finish":1681568278.097257,
//          "duration":0.02600383758544922,
//          "processing":0.0005891323089599609,
//          "date_start":"2023-04-15T17:17:58+03:00",
//          "date_finish":"2023-04-15T17:17:58+03:00",
//          "operating_reset_at":1681568878,
//          "operating":0
//  }
//}
//} {"file":"/Users/mesilov/work/msk03-dev/loyalty/bitrix24-php-sdk/src/Core/Response/Response.php","line":92,"class":"Bitrix24\\SDK\\Core\\Response\\Response","function":"getResponseData","memory_usage":"36 MB"}
//[2023-04-15T14:17:57.881514+00:00] integration-test.DEBUG: handleApiLevelErrors.start [] {"file":"/Users/mesilov/work/msk03-dev/loyalty/bitrix24-php-sdk/src/Core/Response/Response.php","line":152,"class":"Bitrix24\\SDK\\Core\\Response\\Response","function":"handleApiLevelErrors","memory_usage":"36 MB"}
//[2023-04-15T14:17:57.881645+00:00] integration-test.DEBUG: handleApiLevelErrors.finish [] {"file":"/Users/mesilov/work/msk03-dev/loyalty/bitrix24-php-sdk/src/Core/Response/Response.php","line":190,"class":"Bitrix24\\SDK\\Core\\Response\\Response","function":"handleApiLevelErrors","memory_usage":"36 MB"}
//[2023-04-15T14:17:57.881795+00:00] integration-test.DEBUG: getResponseData.parseResponse.finish []
//[2023-04-15T14:37:47.371152+00:00] integration-test.INFO: getResponseData.responseBody {"responseBody":{"result":{"result":[],"result_error":{"f26b4ebc-3a82-4fe6-8d26-595d6eaf029b":{"error":"OPERATION_TIME_LIMIT","error_description":"Method is blocked due to operation time limit."}},"result_total":[],"result_next":[],"result_time":[]},"time":{"start":1681569467.49515,"finish":1681569467.519364,"duration":0.02421402931213379,"processing":0.0005979537963867188,"date_start":"2023-04-15T17:37:47+03:00","date_finish":"2023-04-15T17:37:47+03:00","operating_reset_at":1681570067,"operating":0}}} {"file":"/Users/mesilov/work/msk03-dev/loyalty/bitrix24-php-sdk/src/Core/Response/Response.php","line":92,"class":"Bitrix24\\SDK\\Core\\Response\\Response","function":"getResponseData","memory_usage":"36 MB"}
//[2023-04-15T14:37:47.371279+00:00] integration-test.DEBUG: handleApiLevelErrors.start [] {"file":"/Users/mesilov/work/msk03-dev/loyalty/bitrix24-php-sdk/src/Core/Response/Response.php","line":152,"class":"Bitrix24\\SDK\\Core\\Response\\Response","function":"handleApiLevelErrors","memory_usage":"36 MB"}


        // шаг 2 - сделать отдельные стратегии с логикой для батча и придумать, как может быть
        // - 2.1 ожидание разблокировки метода без завершения работы батча, т.е. скрипт будет висеть 10 минут, потом попробует продолжить работу, такое можно делать толкьо осознавая последсвия
        // - 2.2 выброс события \ вызов обработчика за N секунд до блокировки метода, т.е делегируем логику обработки в клиентский код


    }

    /**
     * Get contacts for update command
     *
     * @param int $contactsToUpdateCount
     * @return array
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    private function getContactsUpdateCommand(int $contactsToUpdateCount): array
    {
        $filter = ['>ID' => '1'];

        $contactsCount = $this->contactService->countByFilter($filter);
        if ($contactsCount < $contactsToUpdateCount) {
            throw new RuntimeException(sprintf('Not enough contacts for test. Need %s, but have %s', $contactsToUpdateCount, $contactsCount));
        }

        $contactsToUpdate = [];
        foreach ($this->contactService->batch->list([], $filter, ['ID', 'COMMENTS'], $contactsToUpdateCount) as $b24Contact) {
            $contactsToUpdate[$b24Contact->ID] = [
                'fields' => [
                    'COMMENTS' => $b24Contact->COMMENTS . time() . PHP_EOL,
                ],
                'params' => [],
            ];
        }
        return $contactsToUpdate;
    }

    public function setUp(): void
    {
        $this->batch = Fabric::getBatchService();
        $this->contactService = Fabric::getServiceBuilder()->getCRMScope()->contact();
    }
}