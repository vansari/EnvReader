<?php

declare(strict_types=1);

namespace Vansari\EnvReader;

use Vansari\EnvReader\Exception\NotFoundException;
use Vansari\EnvReader\Types\ArrayType;
use Vansari\EnvReader\Types\BooleanType;
use Vansari\EnvReader\Types\FloatType;
use Vansari\EnvReader\Types\IntegerType;
use Vansari\EnvReader\Types\StringType;
use Vansari\EnvReader\Types\TypeCollection;

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

    /**
     * @throws NotFoundException
     */
    public function get(string $env, string $type): mixed
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
