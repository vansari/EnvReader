<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Types;

use DevCircleDe\EnvReader\Exception\ConvertionException;

class JsonType implements TypeInterface
{
    public function getName(): string
    {
        return 'json';
    }

    public function convert(mixed $value): array
    {
        $content = json_decode($value, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new ConvertionException('Json could not be converted: ' . json_last_error_msg());
        }

        return $content;
    }
}
