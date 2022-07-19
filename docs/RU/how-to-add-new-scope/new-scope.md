# Добавление (scope telephony)
1. Для начало следует разместить локально сам проект (telephony).
2. Далее следует выполнить команду 
```
composer install
```
 Если при выполнении этой команды вылезли ошибки, то скорее всего следует доставить зависимости. И снова выполнить вышеприведенную команду.
3. Регистрируемся на портале Битрикс 24 и создаем локальное приложение (инструкция по созданию локального приложения находится по пути: `docs/RU/Application/new-local-application.md` ).
4. Далее следует почитать документацию и презентацию. Ссылка на документацию: `https://symfony.com/doc/current/http_client.html`, презентация называется `The_Modern_And_Fast_HttpClient` и ее можно легко найти в интернете.
5. В папке `src/Services` размещаем наш скоуп с Телефонией.
      1. Создаем две папки Result и Service
      2. В папке Service будут размещены сервисы с их методами.
            1. Для примера создадим сервис ExternalLine с одним из методов.
            ```php
            <?php
            declare(strict_types=1);
            namespace Bitrix24\SDK\Services\Telephony\Service;
            use Bitrix24\SDK\Services\AbstractService;
            use Bitrix24\SDK\Services\Telephony\Result\ExternalLineAddResult;
            use Bitrix24\SDK\Services\Telephony\Result\ExternalLinesResult;
            use Bitrix24\SDK\Services\Telephony\Result\ExternalLineDeleteResult;
            use Bitrix24\SDK\Services\Telephony\Result\ExternalLineUpdateResult;

            class ExternalLine extends AbstractService{
            /**
            * The method adds an outer line
            *
            * @param string $lineNumber
            * @param string $nameLine
            *
            *  @return \Bitrix24\SDK\Services\Telephony\Result\ExternalLineAddResult
            * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
            * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
            * @link https://training.bitrix24.com/rest_help/scope_telephony/telephony/telephony_externalLine_add.php
            */

            public function add(string $lineNumber , string $nameLine): ExternalLineAddResult
            {
            return new ExternalLineAddResult(
              $this->core->call(
               'telephony.externalLine.add',
               [
               'NUMBER' => $lineNumber,
               'NAME' => $nameLine,
               ] 
             ));
            }
            ```
      3. В папке Result будут размещены результаты наших методов(то что они будут возвращать).
          1. Для примера создадим ExternalLineAddResult.php
          ```php 
          <?php

          declare(strict_types=1);

          namespace Bitrix24\SDK\Services\Telephony\Result;

          use Bitrix24\SDK\Core\Contracts\AddedItemIdResultInterface;
          use Bitrix24\SDK\Core\Exceptions\BaseException;
          use Bitrix24\SDK\Core\Result\AbstractResult;

         class ExternalLineAddResult extends AbstractResult implements AddedItemIdResultInterface
         {
         /**
         * @return int
         * @throws BaseException
         */
         public function getId(): int
         {
         return $this->getCoreResponse()->getResponseData()->getResult()->getResultData()['ID'];
         }

         }
      4. Также в папке `src/Services/(название вашего сервиса)` размещаем (название вашего сервиса)ServiceBuilder.php. Этот сервис нужен для подключения нашего скоупа с тестами.
6. После того как мы добавили наши методы для работы с Телефонией нужно их затестить. Создадим в папке `tests/Integration/Services/Telephony/Service/` наши тесты и проверим все ли работает как надо ExternalLineTest.php.
    ```php
    <?php
    
    declare(strict_types=1);
    
    namespace Bitrix24\SDK\Tests\Integration\Services\Telephony\Service;
    
    use Bitrix24\SDK\Core\Exceptions\BaseException;
    use Bitrix24\SDK\Core\Exceptions\TransportException;
    use Bitrix24\SDK\Services\Telephony\Service\ExternalLine;
    use Bitrix24\SDK\Tests\Integration\Fabric;
    use PHPUnit\Framework\TestCase;
    
    class ExternalLineTest extends TestCase
    {
        protected ExternalLine $externalLineService;
    
        /**
         * @throws BaseException
         * @throws TransportException
         * @covers ExternalLine::add
         */
        public function testAdd(): void
        {
            self::assertGreaterThan(1, $this->externalLineService->add((string)time(), sprintf('phpUnit-%s', time()))->getId());
        }
       /**
         * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
         */
        public function setUp(): void
        {
          $this->externalLineService = Fabric::getServiceBuilder()->getTelephonyScope()->externalline();
        }
   }
    ```