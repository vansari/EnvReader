<?php

declare(strict_types=1);

namespace devcirclede\EnvReader\Types;

use devcirclede\EnvReader\Exception\ConvertionException;

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

        return array_filter(
            array_map('trim', explode(',', $match['values'])),
            fn ($value) => '' !== $value
        );
    }
}