<?php

declare(strict_types=1);

namespace devcirclede\EnvReader\Types;

interface TypeInterface
{
    public function getName(): string;

    public function convert(mixed $value): mixed;
}
