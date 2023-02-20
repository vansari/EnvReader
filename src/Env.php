<?php

declare(strict_types=1);

namespace Freesoftde\EnvReader;

use Freesoftde\EnvReader\Types\BooleanType;
use Freesoftde\EnvReader\Types\FloatType;
use Freesoftde\EnvReader\Types\IntegerType;
use Freesoftde\EnvReader\Types\StringType;
use Freesoftde\EnvReader\Types\TypeCollection;

/**
 * @psalm-api
 */
final class Env
{
    private static ?Env $instance = null;
    private TypeCollection $collection;

    private function __construct()
    {
        $this->collection = new TypeCollection(
            new StringType(),
            new IntegerType(),
            new FloatType(),
            new BooleanType(),
        );
    }

    public function getCollection(): TypeCollection
    {
        return $this->collection;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance(): Env
    {
        if (null === self::$instance) {
            self::$instance = new Env();
        }

        return self::$instance;
    }

    public function get(string $env, string $type): mixed
    {
        if (false === (bool)($value = $_ENV[$env] ?? $_SERVER[$env] ?? getenv($env))) {
            return null;
        }

        return $this->collection->getItem($type)->convert($value);
    }
}
