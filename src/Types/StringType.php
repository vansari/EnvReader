<?php
declare(strict_types=1);

namespace Freesoftde\EnvReader\Types;

class StringType implements TypeInterface
{

    public function getName(): string
    {
        return 'string';
    }

    public function convert(mixed $value): string
    {
        return (string)$value;
    }
}