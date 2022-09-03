<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Service;

use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Response\Response;
use Bitrix24\SDK\Services\AbstractService;
use Bitrix24\SDK\Services\Main\Result\EventHandlerBindResult;
use Bitrix24\SDK\Services\Main\Result\EventHandlersResult;
use Bitrix24\SDK\Services\Main\Result\EventHandlerUnbindResult;
use Bitrix24\SDK\Services\Main\Result\EventListResult;

class Event extends AbstractService
{
    /**
     * Displays events from the general list of events.
     *
     * @param string|null $scopeCode
     *
     * @return EventListResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Core\Exceptions\UnknownScopeCodeException
     * @link https://training.bitrix24.com/rest_help/general/events_method/events.php
     */
    public function list(?string $scopeCode = null): EventListResult
    {
        return new EventListResult(
            $this->core->call(
                'events',
                $scopeCode !== null ? ['scope' => (new Scope([$scopeCode]))->getScopeCodes()[0]] : []
            )
        );
    }

    /**
     * Installs a new event handler.
     *
     * @param string     $eventCode
     * @param string     $handlerUrl
     * @param int|null   $userId
     * @param array|null $options
     *
     * @return \Bitrix24\SDK\Services\Main\Result\EventHandlerBindResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/general/events_method/event_bind.php
     */
    public function bind(string $eventCode, string $handlerUrl, ?int $userId = null, ?array $options = null): EventHandlerBindResult
    {
        $params = [
            'event'          => $eventCode,
            'handler'        => $handlerUrl,
            'event_type	' => 'online',
        ];
        if ($userId !== null) {
            $params['auth_type'] = $userId;
        }
        if (is_array($options)) {
            $params = array_merge($params, $options);
        }

        return new EventHandlerBindResult($this->core->call('event.bind', $params));
    }

    /**
     * Uninstalls a previously installed event handler.
     *
     * @param string   $eventCode
     * @param string   $handlerUrl
     * @param int|null $userId
     *
     * @return \Bitrix24\SDK\Services\Main\Result\EventHandlerUnbindResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/general/events_method/event_unbind.php
     */
    public function unbind(string $eventCode, string $handlerUrl, ?int $userId = null): EventHandlerUnbindResult
    {
        $params = [
            'event'          => $eventCode,
            'handler'        => $handlerUrl,
            'event_type	' => 'online',
        ];
        if ($userId !== null) {
            $params['auth_type'] = $userId;
        }

        return new EventHandlerUnbindResult($this->core->call('event.unbind', $params));
    }

    /**
     * @param array $payload
     *
     * @return \Bitrix24\SDK\Core\Response\Response
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/rest_sum/test_handler.php
     */
    public function test(array $payload = []): Response
    {
        return $this->core->call('event.test', $payload);
    }

    /**
     * Obtaining a list of registered event handlers.
     *
     * @return \Bitrix24\SDK\Services\Main\Result\EventHandlersResult
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @link https://training.bitrix24.com/rest_help/general/events_method/event_get.php
     */
    public function get(): EventHandlersResult
    {
        return new EventHandlersResult($this->core->call('event.get'));
    }
}