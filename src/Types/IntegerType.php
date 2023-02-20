<?php

declare(strict_types=1);

namespace Freesoftde\EnvReader\Types;

use Freesoftde\EnvReader\Exception\ConvertionException;

class IntegerType implements TypeInterface
{
    public function getName(): string
    {
        return 'integer';
    }

    public function convert(mixed $value): int
    {
        if (
            false === (
                $filtered = (filter_var($value, \FILTER_VALIDATE_FLOAT)
                    ?: filter_var($value, \FILTER_VALIDATE_INT))
            )
        ) {
            throw new ConvertionException("Could not convert value $value to int.");
        }

        return (int)$filtered;
    }
}
