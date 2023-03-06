<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

interface TypeInterface
{
    public function getName(): string;

    public function convert(string $value): mixed;
}
