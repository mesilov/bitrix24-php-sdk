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

namespace Bitrix24\SDK\Core\BulkItemsReader\ReadStrategies;

use Bitrix24\SDK\Core\Contracts\BulkItemsReaderInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Generator;
use Psr\Log\LoggerInterface;

class FilterWithoutBatchWithoutCountOrder implements BulkItemsReaderInterface
{
    public function __construct(private readonly CoreInterface $core, private readonly LoggerInterface $log)
    {
    }

    /**
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function getTraversableList(string $apiMethod, array $order, array $filter, array $select, ?int $limit = null): Generator
    {
        $this->log->debug('FilterWithoutBatchWithoutCountOrder.getTraversableList.start', [
            'apiMethod' => $apiMethod,
            'order'     => $order,
            'filter'    => $filter,
            'select'    => $select,
            'limit'     => $limit,
        ]);

        // Дефолтная стратегия из документации https://dev.1c-bitrix.ru/rest_help/rest_sum/start.php
        //
        //Особенности:
        //— ✅ отключён подсчёт количества элементов в выборке
        //— ⚠️ ID элементов в выборке возрастает, т.е. была сделана сортировка результатов по ID
        //— не используем batch
        //— ❗️ парсим ответ сервера для получения следующего ID → проблемы с распараллеливанием запросов
        //— последовательное выполнение запросов
        //
        //Задел по оптимизации
        //— ограниченное использование параллельных запросов
        //
        // Запросы отправляются к серверу последовательно с параметром "order": {"ID": "ASC"} (сортировка по возрастанию ID),
        // и в каждом последующем запросе используются результаты предыдущего (фильтрация по ID, где ID > максимального ID в результатах
        // предыдущего запроса).
        //
        // При этом для ускорения используется параметр start = -1 для отключения затратной по времени операции расчета общего
        // количества записей (поле total), которое по умолчанию возвращается в каждом ответе сервера при вызове методов вида *.list.
        //
        // В потенциале для ускорения можно попытаться параллельно передвигаться по списку сущностей в два потока:
        // с начала списка и с конца, продолжая получать страницы, пока ID в двух потоках не пересекутся.
        // Такой способ, возможно, будет давать двукратное ускорение до тех пор, пока не будет исчерпан пул запросов к серверу и не
        // потребуется включить throttling.


        // get total elements count


        // получили первый id элемента в выборке по фильтру
        // todo проверили, что это *.list команда
        // todo проверили, что в селекте есть ID, т.е. разработчик понимает, что ID используется
        // todo проверили, что сортировка задана как "order": {"ID": "ASC"} т.е. разработчик понимает, что данные придут в таком порядке
        // todo проверили, что если есть limit, то он >1
        // todo проверили, что в фильтре нет поля ID, т.к. мы с ним будем работать


        $firstElementId = $this->getFirstElementId($apiMethod, $filter, $select);
        if ($firstElementId === null) {
            $this->log->debug('FilterWithoutBatchWithoutCountOrder.getTraversableList.emptySelect');

            return;
        }

        $lastElementId = $this->getLastElementId($apiMethod, $filter, $select);
        if ($lastElementId === null) {
            $this->log->debug('FilterWithoutBatchWithoutCountOrder.getTraversableList.emptySelect');

            return;
        }

        // делаем запросы к Б24
        // todo учесть ретраии
        // todo ограничения по количеству запросов в секунду + пул запросов
        $currentElementId = $firstElementId;
        $isStop = false;
        while (!$isStop) {
            $filterQuery = '>ID';
            if ($currentElementId === $firstElementId) {
                $filterQuery = '>=ID';
            }

            $resultPage = $this->core->call(
                $apiMethod,
                [
                    'order'  => ['ID' => 'ASC'],
                    'filter' => array_merge(
                        [$filterQuery => $currentElementId],
                        $filter
                    ),
                    'select' => array_unique(array_merge(['ID'], $select)),
                    'start'  => -1,
                ]
            );


            foreach ($resultPage->getResponseData()->getResult() as $cnt => $item) {


                $currentElementId = (int)$item['ID'];
                yield $cnt => $item;
            }

            $this->log->debug('FilterWithoutBatchWithoutCountOrder.step', [
                'duration'         => $resultPage->getResponseData()->getTime()->duration,
                'currentElementId' => $currentElementId,
                'lastElementId'    => $lastElementId,
            ]);
            if ($currentElementId >= $lastElementId) {
                $isStop = true;
            }
        }
    }

    /**
     * Get first element id in filtered result ordered by id asc
     *
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @todo Кандидат на вынос
     */
    private function getFirstElementId(string $apiMethod, array $filter, array $select): ?int
    {
        $this->log->debug('FilterWithoutBatchWithoutCountOrder.getFirstElementId.start', [
            'apiMethod' => $apiMethod,
            'filter'    => $filter,
            'select'    => $select,
        ]);

        $response = $this->core->call(
            $apiMethod,
            [
                'order'  => ['ID' => 'ASC'],
                'filter' => $filter,
                'select' => $select,
                'start'  => 0,
            ]
        );

        $elementId = $response->getResponseData()->getResult()[0]['ID'];

        $this->log->debug('FilterWithoutBatchWithoutCountOrder.getFirstElementId.finish', [
            'elementId' => $elementId,
        ]);

        return $elementId === null ? null : (int)$elementId;
    }

    /**
     * Get first element id in filtered result ordered by id asc
     *
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @todo Кандидат на вынос
     */
    private function getLastElementId(string $apiMethod, array $filter, array $select): ?int
    {
        $this->log->debug('FilterWithoutBatchWithoutCountOrder.getLastElementId.start', [
            'apiMethod' => $apiMethod,
            'filter'    => $filter,
            'select'    => $select,
        ]);

        $response = $this->core->call(
            $apiMethod,
            [
                'order'  => ['ID' => 'DESC'],
                'filter' => $filter,
                'select' => $select,
                'start'  => 0,
            ]
        );

        $elementId = $response->getResponseData()->getResult()[0]['ID'];

        $this->log->debug('FilterWithoutBatchWithoutCountOrder.getLastElementId.finish', [
            'elementId' => $elementId,
        ]);

        return $elementId === null ? null : (int)$elementId;
    }
}