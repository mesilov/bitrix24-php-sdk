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

namespace Bitrix24\SDK\Core\Result;

use ArrayIterator;
use Bitrix24\SDK\Core\Exceptions\ImmutableResultViolationException;
use IteratorAggregate;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Traversable;

/**
 * Class AbstractItem
 *
 * @package Bitrix24\SDK\Core\Result
 */
abstract class AbstractItem implements IteratorAggregate
{
    protected DecimalMoneyParser $decimalMoneyParser;

    public function __construct(protected array $data)
    {
        $this->decimalMoneyParser = new DecimalMoneyParser(new ISOCurrencies());
    }

    /**
     * @param int|string $offset
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
     *
     * @return void
     * @throws ImmutableResultViolationException
     *
     */
    public function __set($offset, mixed $value)
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
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    
    protected function isKeyExists(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }
}