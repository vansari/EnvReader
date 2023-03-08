<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

use DevCircleDe\EnvReader\Exception\ConvertionException;

class IntegerType implements TypeInterface
{
    public function getName(): string
    {
        return 'int';
    }

    public function convert(string $value): int
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
