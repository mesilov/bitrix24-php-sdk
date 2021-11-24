<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Commands;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Ramsey\Uuid\UuidInterface;
use SplObjectStorage;

/**
 * Class CommandCollection
 *
 * @package Bitrix24\SDK\Core\Commands
 *
 * @method attach(Command $command)
 * @method Command current()
 */
class CommandCollection extends SplObjectStorage
{
    private function filter(callable $filterCallback = null)
    {
        $filteredCollection = new static;
        foreach ($this as $item) {
            $itemData = null;
            if ($this->offsetExists($item)) {
                $itemData = $this->offsetGet($item);
            }
            if ($filterCallback !== null && call_user_func_array($filterCallback, [$item, $itemData]) !== true) {
                continue;
            }
            $filteredCollection->attach($item, $itemData);
        }
        $filteredCollection->rewind();

        return $filteredCollection;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $uuid
     *
     * @return \Bitrix24\SDK\Core\Commands\Command
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getByUuid(UuidInterface $uuid): Command
    {
        $filtered = $this->filter(
            static function (Command $item) use ($uuid) {
                return $item->getUuid()->equals($uuid);
            }
        );

        if ($filtered->count() === 1) {
            $filtered->rewind();

            return $filtered->current();
        }

        throw new BaseException(sprintf('command by uuid %s not found', $uuid->toString()));
    }

    /**
     * @param string $name
     *
     * @return \Bitrix24\SDK\Core\Commands\Command
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function getByName(string $name): Command
    {
        $filtered = $this->filter(
            static function (Command $item) use ($name) {
                return $item->getName() === $name;
            }
        );

        if ($filtered->count() === 1) {
            $filtered->rewind();

            return $filtered->current();
        }

        throw new BaseException(sprintf('command by name %s not found', $name));
    }
}