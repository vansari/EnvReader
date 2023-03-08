<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

/**
 * @psalm-api
 */
interface TypeCollectionInterface
{
    public function addItem(TypeInterface $type, bool $overwrite = false): TypeCollectionInterface;

    public function getItem(string $key): TypeInterface;

    /**
     * @return string[]
     */
    public function getKeys(): array;
}
