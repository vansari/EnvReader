<?php

declare(strict_types=1);

namespace devcirclede\EnvReader;

use devcirclede\EnvReader\Exception\NotFoundException;
use devcirclede\EnvReader\Types\ArrayType;
use devcirclede\EnvReader\Types\BooleanType;
use devcirclede\EnvReader\Types\FloatType;
use devcirclede\EnvReader\Types\IntegerType;
use devcirclede\EnvReader\Types\JsonType;
use devcirclede\EnvReader\Types\StringType;
use devcirclede\EnvReader\Types\TypeCollection;

/**
 * @psalm-api
 */
final class EnvParser
{
    private static ?EnvParser $instance = null;
    private TypeCollection $collection;

    private function __construct()
    {
        $this->collection = new TypeCollection(
            new ArrayType(),
            new StringType(),
            new IntegerType(),
            new FloatType(),
            new BooleanType(),
            new JsonType(),
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

    public static function getInstance(): EnvParser
    {
        if (null === self::$instance) {
            self::$instance = new EnvParser();
        }

        return self::$instance;
    }

    /**
     * @throws NotFoundException
     */
    public function parse(string $env, string $type): mixed
    {
        if ('' === $env) {
            throw new \InvalidArgumentException('Variable $env can not be empty.');
        }

        if (null === ($value = $this->findEnv($env))) {
            return null;
        }

        return $this->collection->getItem($type)->convert($value);
    }

    private function findEnv(string $env): ?string
    {
        if (false === (bool)($value = $_ENV[$env] ?? $_SERVER[$env] ?? getenv($env))) {
            return null;
        }

        // We cannot handle arrays which "can be" returned by getenv()
        if (is_array($value)) {
            return null;
        }

        return (string)$value;
    }
}
