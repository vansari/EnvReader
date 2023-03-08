<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

/**
 * @psalm-api
 */
interface TypeCollectionInterface
{
    public function addItem(TypeInterface $type, bool $overwrite = false): TypeCollection;

    public function getItem(string $key): TypeInterface;

    public function getKeys(): array;
}
