<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

use Countable;
use Iterator;

/**
 * @psalm-api
 */
interface TypeCollectionInterface extends Iterator, Countable
{
    public function addItem(TypeInterface $type, bool $overwrite = false): TypeCollectionInterface;

    public function getItem(string $key): TypeInterface;

    /**
     * @return string[]
     */
    public function getKeys(): array;
}
