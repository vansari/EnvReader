<?php

declare(strict_types=1);

namespace Vansari\EnvReader\Types;

interface TypeInterface
{
    public function getName(): string;

    public function convert(string $value): mixed;
}
