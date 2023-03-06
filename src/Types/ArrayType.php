<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

use DevCircleDe\EnvReader\Exception\ConvertionException;

class ArrayType implements TypeInterface
{
    public function getName(): string
    {
        return 'array';
    }

    public function convert(string $value): array
    {
        if (!preg_match('/^\[(?<values>.*)]$/', $value, $match)) {
            throw new ConvertionException('Value must start with "[" and must end with "]".');
        }

        return array_map(
            fn(string $value): string|float|int => filter_var($value, FILTER_VALIDATE_INT)
                ?: filter_var($value, FILTER_VALIDATE_FLOAT)
                    ?: $value,
            array_filter(
                array_map('trim', explode(',', $match['values'])),
                fn($value) => '' !== $value
            )
        );
    }
}
