<?php
declare(strict_types=1);

namespace Freesoftde\EnvReader\Types;

use Freesoftde\EnvReader\Exception\KeyInUseException;
use Freesoftde\EnvReader\Exception\NotFoundException;

class TypeCollection
{
    private array $collection = [];

    public function __construct(TypeInterface ...$types)
    {
        foreach ($types as $type) {
            $this->addItem($type->getName(), $type);
        }
    }

    public function addItem(string $key, TypeInterface $type, bool $overwrite = false): self
    {
        if (array_key_exists($key, $this->collection) && !$overwrite) {
            throw new KeyInUseException("Key '$key' already exists.");
        }

        $this->collection[$key] = $type;

        return $this;
    }

    public function getItem(string $key): TypeInterface
    {
        if (!array_key_exists($key, $this->collection)) {
            throw new NotFoundException($key . ' is not present in collection.');
        }

        return $this->collection[$key];
    }
}