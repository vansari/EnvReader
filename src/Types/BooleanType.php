<?php

declare(strict_types=1);

namespace Freesoftde\EnvReader\Types;

class BooleanType implements TypeInterface
{
    public function getName(): string
    {
        return 'boolean';
    }

    public function convert(mixed $value): bool
    {
        return (bool)filter_var($value, \FILTER_VALIDATE_BOOLEAN);
    }
}
