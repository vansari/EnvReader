<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

use DevCircleDe\EnvReader\Exception\KeyInUseException;
use DevCircleDe\EnvReader\Exception\NotFoundException;

/**
 * @psalm-api
 */
final class TypeCollection implements TypeCollectionInterface
{
    private array $collection = [];
    private int $pos = 0;

    public function __construct(TypeInterface ...$types)
    {
        foreach ($types as $type) {
            $this->addItem($type);
        }
    }

    public function addItem(TypeInterface $type, bool $overwrite = false): TypeCollectionInterface
    {
        if (array_key_exists($type->getName(), $this->collection) && !$overwrite) {
            throw new KeyInUseException("Key '{$type->getName()}' already exists.");
        }

        $this->collection[$type->getName()] = $type;

        return $this;
    }

    public function getItem(string $key): TypeInterface
    {
        if (!array_key_exists($key, $this->collection)) {
            throw new NotFoundException($key . ' is not present in collection.');
        }

        return $this->collection[$key];
    }

    /**
     * @return string[]
     */
    public function getKeys(): array
    {
        return array_keys($this->collection);
    }

    public function current(): mixed
    {
        return $this->collection[array_keys($this->collection)[$this->pos]];
    }

    public function next(): void
    {
        $this->pos++;
    }

    public function key(): string
    {
        return array_keys($this->collection)[$this->pos];
    }

    public function valid(): bool
    {
        return $this->pos < count($this->collection);
    }

    public function rewind(): void
    {
        $this->pos = 0;
    }

    public function count(): int
    {
        return count($this->collection);
    }
}
