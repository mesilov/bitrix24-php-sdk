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
            foreach ($alreadyInstalledHandlers as $alreadyInstalledHandler) {
                $this->logger->debug('bindEventHandlers.isHandlerInstalled', [
                    'handlerToInstallCode' => $eventHandler->code,
                    'handlerToInstallUrl' => $eventHandler->handlerUrl,
                    'isInstalled' => $eventHandler->isInstalled($alreadyInstalledHandler)
                ]);
                if ($eventHandler->isInstalled($alreadyInstalledHandler)) {
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
        $eventHandlersResult = $this->eventService->get();
        if ($eventHandlersResult->getEventHandlers() === []) {
            return $eventHandlersResult;
        }

        $handlersToUnbind = $eventHandlersResult->getEventHandlers();
        // todo replace to batch call
        foreach ($handlersToUnbind as $handlerToUnbind) {
            $this->logger->debug('unbindAllEventHandlers.handler', [
                'code' => $handlerToUnbind->event,
                'handler' => $handlerToUnbind->handler,
            ]);
            $this->eventService->unbind(
                $handlerToUnbind->event,
                $handlerToUnbind->handler
            );
        }

        return $eventHandlersResult;
    }
}