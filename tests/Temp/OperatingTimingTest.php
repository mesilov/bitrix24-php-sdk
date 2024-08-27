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
        // Since the Rest module version 22.0.0 in the cloud version of Bitrix24 in all rest request responses in the time array with
        // with additional information about the request execution time, an additional operating key has been added, which
        // talks about the execution time of a request to a method by a specific application. Query execution time data
        // the method is summed up. If the query execution time exceeds 480 seconds within the past 10 minutes
        // this method is blocked for the application. However, all other methods continue to work.
        // The operating_reset_at key returns the timestamp at which part of the limit for this method will be released.

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
// //todo count the number of contacts to update and count the number of contacts that were updated, if it doesn’t match, then we crash with an error


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

        // step 1 - throwing a correct exception, saying that the method failed because the method was blocked
        // problems: - you can lose some data when updating, because We don’t know which contacts in the client code have been updated and which ones haven’t, or do we know?
        // todo clarification, if possible, return in an exception the remainder of the data that has not yet been updated
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


        // step 2 - make separate strategies with logic for the batch and figure out how it could be
        // - 2.1 waiting for the method to be unlocked without completing the batch, i.e. the script will hang for 10 minutes, then try to continue working, this can only be done if you are aware of the consequences
        // - 2.2 event release \ handler call N seconds before the method is blocked, i.e. we delegate the processing logic to the client code

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