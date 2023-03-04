<?php

declare(strict_types=1);

namespace devcirclede\EnvReader\Types;

class BooleanType implements TypeInterface
{
    public function getName(): string
    {
        return 'boolean';
    }

    public function convert(string $value): bool
    {
        return (bool)filter_var($value, \FILTER_VALIDATE_BOOLEAN);
    }
}
