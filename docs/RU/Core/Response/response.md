# Возвращаемый результат

ApiClient возвращает результат в виде объекта `Symfony\Contracts\HttpClient\ResponseInterface`

В клиентский код возвращается объект типа `Core\Response\DTO` который имеет метод `getResponseData(): DTO\ResponseData`
он конструирует унифицированный DTO ответа сервера состоящий из двух полей
- результат работы в виде массива
- время работы – объект типа `Core\Response\DTO\Time`

Т.е. для удобства работы всегда имеет смысл работать с объектом  `Core\Response\DTO`