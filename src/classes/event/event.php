<?php

namespace Bitrix24\Event;

use Bitrix24\Bitrix24Entity;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Presets\Event\Event as EventType;

/**
 * Class Event.
 */
class event extends Bitrix24Entity
{
    /**
     * check is event handler code valid.
     *
     * @param $eventHandlerName
     *
     * @return bool
     */
    protected function isEventHandlerCodeValid($eventHandlerName)
    {
        $isEventHandlerCodeValid = false;
        switch (strtoupper($eventHandlerName)) {
            case EventType::ON_APP_UPDATE:
            case EventType::ON_APP_PAYMENT:
            case EventType::ON_APP_UNINSTALL:
            case EventType::ON_TASK_ADD:
            case EventType::ON_TASK_DELETE:
            case EventType::ON_TASK_UPDATE:
            case EventType::ON_USER_ADD:
            case EventType::ON_CRM_ACTIVITY_ADD:
            case EventType::ON_CRM_ACTIVITY_DELETE:
            case EventType::ON_CRM_ACTIVITY_UPDATE:
            case EventType::ON_CRM_COMPANY_ADD:
            case EventType::ON_CRM_COMPANY_DELETE:
            case EventType::ON_CRM_COMPANY_UPDATE:
            case EventType::ON_CRM_CONTACT_ADD:
            case EventType::ON_CRM_CONTACT_DELETE:
            case EventType::ON_CRM_CONTACT_UPDATE:
            case EventType::ON_CRM_CURRENCY_ADD:
            case EventType::ON_CRM_CURRENCY_DELETE:
            case EventType::ON_CRM_CURRENCY_UPDATE:
            case EventType::ON_CRM_DEAL_ADD:
            case EventType::ON_CRM_DEAL_DELETE:
            case EventType::ON_CRM_DEAL_UPDATE:
            case EventType::ON_CRM_LEAD_ADD:
            case EventType::ON_CRM_LEAD_DELETE:
            case EventType::ON_CRM_LEAD_UPDATE:
            case EventType::ON_CRM_PRODUCT_ADD:
            case EventType::ON_CRM_PRODUCT_DELETE:
                $isEventHandlerCodeValid = true;
                break;
        }

        return $isEventHandlerCodeValid;
    }

    /**
     * Get list of register events.
     *
     * @return array
     */
    public function get()
    {
        $fullResult = $this->client->call(
            'event.get',
            []
        );

        return $fullResult;
    }

    /**
     * Get list of all supported events.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/general/events.php
     *
     * @return array
     */
    public function getList()
    {
        $fullResult = $this->client->call(
            'events',
            []
        );

        return $fullResult;
    }

    /**
     * Register new event handler. Work only for user with portal administrator rights.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/general/event_bind.php
     *
     * @param $eventName string event handler code
     * @param $handler string event handler URL
     * @param $authType integer user identifier, under witch event handler was executed
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function bind($eventName, $handler, $authType = null)
    {
        if (!$this->isEventHandlerCodeValid($eventName)) {
            throw new Bitrix24Exception('eventName is invalid');
        }
        if (is_null($handler)) {
            throw new Bitrix24Exception('handler URL is null');
        }
        $fullResult = $this->client->call(
            'event.bind',
            [
                'event'     => $eventName,
                'handler'   => $handler,
                'auth_type' => $authType,
            ]
        );

        return $fullResult;
    }

    /**
     * Unregister event handler. Work only for user with portal administrator rights.
     *
     * @link http://dev.1c-bitrix.ru/rest_help/general/event_unbind.php
     *
     * @param $eventName
     * @param $handler
     * @param null $authType
     *
     * @return array
     */
    public function unbind($eventName = null, $handler = null, $authType = null)
    {
        $fullResult = $this->client->call(
            'event.unbind',
            [
                'event'     => $eventName,
                'handler'   => $handler,
                'auth_type' => $authType,
            ]
        );

        return $fullResult;
    }
}
