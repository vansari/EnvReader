<?php

declare(strict_types=1);

namespace devcirclede\EnvReader;

use devcirclede\EnvReader\Types\ArrayType;
use devcirclede\EnvReader\Types\BooleanType;
use devcirclede\EnvReader\Types\FloatType;
use devcirclede\EnvReader\Types\IntegerType;
use devcirclede\EnvReader\Types\StringType;
use devcirclede\EnvReader\Types\TypeCollection;

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
            new ArrayType(),
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
