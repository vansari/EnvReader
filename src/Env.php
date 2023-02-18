<?php
declare(strict_types=1);

namespace Freesoftde\EnvReader;

class Env
{
    private static ?Env $instance = null;

    private function __construct() {}

    public function get(string $env, string $type): mixed
    {
        if (false === (bool)($value = $_ENV[$env] ?? $_SERVER[$env] ?? getenv($env))) {
            return null;
        }

        return match($type) {
            'string' => $this->asString($value)
        };
    }

    private function __clone() {}

    private function __wakeup() {}

    public static function getInstance(): static
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    private function asString(mixed $value): string
    {
        return (string)$value;
    }
}