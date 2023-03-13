<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader;

use DevCircleDe\EnvReader\Exception\NotFoundException;
use DevCircleDe\EnvReader\Types\ArrayType;
use DevCircleDe\EnvReader\Types\BooleanType;
use DevCircleDe\EnvReader\Types\FloatType;
use DevCircleDe\EnvReader\Types\IntegerType;
use DevCircleDe\EnvReader\Types\JsonType;
use DevCircleDe\EnvReader\Types\StringType;
use DevCircleDe\EnvReader\Types\TypeCollection;

/**
 * @psalm-api
 */
final class EnvParser implements EnvParserInterface
{
    private TypeCollection $collection;

    public function __construct(?TypeCollection $collection = null)
    {
        $this->collection = $collection ?? new TypeCollection(
            new ArrayType(),
            new StringType(),
            new IntegerType(),
            new FloatType(),
            new BooleanType(),
            new JsonType(),
        );
    }

    public static function create(): EnvParserInterface
    {
        return new self();
    }

    public function getCollection(): TypeCollection
    {
        return $this->collection;
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
