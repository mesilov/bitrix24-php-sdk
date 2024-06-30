<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Main\Service;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Bitrix24\SDK\Services\Main\Common\EventHandlerMetadata;
use Bitrix24\SDK\Services\Main\Result\EventHandlersResult;
use Psr\Log\LoggerInterface;

readonly class EventManager
{
    public function __construct(
        protected Event           $eventService,
        protected LoggerInterface $logger
    )
    {
    }

    /**
     * @param EventHandlerMetadata[] $eventHandlerMetadata
     * @return void
     * @throws InvalidArgumentException
     */
    public function bindEventHandlers(array $eventHandlerMetadata): void
    {
        // check input arguments
        foreach ($eventHandlerMetadata as $eventHandler) {
            if (!$eventHandler instanceof EventHandlerMetadata) {
                throw new InvalidArgumentException(
                    sprintf('in eventHandlerMetadata we need only EventHandlerMetadata objects, we got an «%s»', gettype($eventHandler)));
            }
            $this->logger->debug('bindEventHandlers.handlerItem', [
                'code' => $eventHandler->code,
                'url' => $eventHandler->handlerUrl,
                'userId' => $eventHandler->userId,
                'options' => $eventHandler->options
            ]);
        }

        // is handler already installed?
        $toInstall = [];
        $alreadyInstalledHandlers = $this->eventService->get()->getEventHandlers();
        foreach ($eventHandlerMetadata as $eventHandler) {
            $isInstalled = false;
            foreach ($alreadyInstalledHandlers as $installedHandler) {
                $this->logger->debug('bindEventHandlers.isHandlerInstalled', [
                    'handlerToInstallCode' => $eventHandler->code,
                    'handlerToInstallUrl' => $eventHandler->handlerUrl,
                    'isInstalled' => $eventHandler->isInstalled($installedHandler)
                ]);
                if ($eventHandler->isInstalled($installedHandler)) {
                    $this->logger->debug('bindEventHandlers.handlerAlreadyInstalled', [
                        'code' => $eventHandler->code,
                        'handlerUrl' => $eventHandler->handlerUrl
                    ]);

                    $isInstalled = true;
                    break;
                }
            }
            if (!$isInstalled) {
                $toInstall[] = $eventHandler;
                $this->logger->debug('bindEventHandlers.handlerAddedToInstallPlan', [
                    'code' => $eventHandler->code,
                    'handlerUrl' => $eventHandler->handlerUrl
                ]);
            }
        }

        // install event handlers
        $this->logger->debug('bindEventHandlers.handlersToInstall', [
            'count' => count($toInstall)
        ]);
        // todo replace to batch call
        foreach ($toInstall as $eventHandler) {
            $this->eventService->bind(
                $eventHandler->code,
                $eventHandler->handlerUrl,
                $eventHandler->userId,
                $eventHandler->options
            );
        }
    }

    public function unbindAllEventHandlers(): EventHandlersResult
    {
        $activeHandlers = $this->eventService->get();
        if (count($activeHandlers->getEventHandlers()) === 0) {
            return $activeHandlers;
        }

        $handlersToUnbind = $activeHandlers->getEventHandlers();
        // todo replace to batch call
        foreach ($handlersToUnbind as $itemHandler) {
            $this->logger->debug('unbindAllEventHandlers.handler', [
                'code' => $itemHandler->event,
                'handler' => $itemHandler->handler,
            ]);
            $this->eventService->unbind(
                $itemHandler->event,
                $itemHandler->handler
            );
        }
        return $activeHandlers;
    }
}