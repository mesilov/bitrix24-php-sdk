<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Result;

use Bitrix24\SDK\Core\Exceptions\ImmutableResultViolationException;

/**
 * Class AbstractItem
 *
 * @package Bitrix24\SDK\Core\Result
 */
abstract class AbstractItem implements \IteratorAggregate
{
    protected array $data;

    /**
     * AbstractItem constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param int|string $offset
     *
     * @return bool
     */
    public function __isset($offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param int|string $offset
     *
     * @return mixed
     */
    public function __get($offset)
    {
        return $this->data[$offset] ?? null;
    }

    /**
     * @param int|string $offset
     * @param mixed      $value
     *
     * @return void
     * @throws ImmutableResultViolationException
     *
     */
    public function __set($offset, $value)
    {
        throw new ImmutableResultViolationException(sprintf('Result is immutable, violation at offset %s', $offset));
    }

    /**
     * @param int|string $offset
     *
     * @throws ImmutableResultViolationException
     */
    public function __unset($offset)
    {
        throw new ImmutableResultViolationException(sprintf('Result is immutable, violation at offset %s', $offset));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function isKeyExists(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }
}