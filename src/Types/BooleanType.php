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
        // TODO: Implement convert() method.
    }
}