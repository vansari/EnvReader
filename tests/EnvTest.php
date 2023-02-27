<?php

declare(strict_types=1);

namespace devcirclede\EnvReader\Test;

use devcirclede\EnvReader\Env;
use devcirclede\EnvReader\Exception\NotFoundException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    public static function providerTestGetWillPass(): array
    {
        return [
            'Get Env as String' => [
                'SOME_ENV',
                'text',
                'string',
                'text',
            ],
            'Get Env as Int' => [
                'SOME_ENV',
                '1234',
                'integer',
                1234,
            ],
            'Get Env as Float' => [
                'SOME_ENV',
                '1234.56',
                'float',
                1234.56,
            ],
            'Get Env ON as Bool' => [
                'SOME_ENV',
                'ON',
                'boolean',
                true
            ],
            'Get Env "false" as Bool' => [
                'SOME_ENV',
                'false',
                'boolean',
                false
            ],
            'Get Env array as Array' => [
                'SOME_ENV',
                '[1,a,2,b,3,c]',
                'array',
                [1, 'a', 2, 'b', 3, 'c'],
            ]
        ];
    }

    #[DataProvider('providerTestGetWillPass')]
    public function testGetWillPassWithPutenv(?string $env, mixed $value, string $type, mixed $expected): void
    {
        putenv("$env=$value");
        $envValue = Env::getInstance()->get($env, $type);
        $this->assertSame($expected, $envValue);
        putenv($env);
    }

    #[DataProvider('providerTestGetWillPass')]
    public function testGetWillPassWithENV(?string $env, mixed $value, string $type, mixed $expected): void
    {
        $_ENV[$env] = $value;
        $envValue = Env::getInstance()->get($env, $type);
        $this->assertSame($expected, $envValue);
        unset($_ENV[$env]);
    }

    #[DataProvider('providerTestGetWillPass')]
    public function testGetWillPassWithSERVER(?string $env, mixed $value, string $type, mixed $expected): void
    {
        $_SERVER[$env] = $value;
        $envValue = Env::getInstance()->get($env, $type);
        $this->assertSame($expected, $envValue);
        unset($_SERVER[$env]);
    }

    public function testGetWillReturnNullIfNotExists(): void
    {
        $envValue = Env::getInstance()->get('NOT_EXISTS', 'string');
        $this->assertNull($envValue);
    }

    public function testGetWillFail(): void
    {
        putenv("SOME_ENV=WERT");
        try {
            Env::getInstance()->get('SOME_ENV', 'custom_type');
            $this->fail('Get must fail if type not registered');
        } catch (\Exception $exception) {
            $this->assertInstanceOf(NotFoundException::class, $exception);
        } finally {
            putenv('SOME_ENV');
        }
    }
}
