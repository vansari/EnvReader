<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

use Countable;
use Iterator;

/**
 * @psalm-api
 * @template-extends Iterator<string, TypeInterface>
 */
interface TypeCollectionInterface extends Iterator, Countable
{
    /**
     * @param TypeInterface $type
     * @param bool $overwrite
     * @return TypeCollectionInterface
     */
    public function addItem(TypeInterface $type, bool $overwrite = false): TypeCollectionInterface;

    /**
     * @param string $key
     * @return TypeInterface
     */
    public function getItem(string $key): TypeInterface;

    /**
     * @return string[]
     */
    public function getKeys(): array;
}
