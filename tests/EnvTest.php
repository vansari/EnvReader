<?php
declare(strict_types=1);

namespace Freesoftde\EnvReader\Test;

use Freesoftde\EnvReader\Env;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{

    public static function provider_testGetWillPass(): array
    {
        return [
            'Get Env as String' => [
                'SOME_ENV',
                'text',
                'string',
                'text',
            ],
        ];
    }

    #[DataProvider('provider_testGetWillPass')]
    public function testGetWillPassWithPutenv(?string $env, mixed $value, string $type, string $expected): void
    {
        putenv("$env=$value");
        $envValue = Env::getInstance()->get($env, $type);
        $this->assertSame($expected, $envValue);
        putenv($env);
    }

    #[DataProvider('provider_testGetWillPass')]
    public function testGetWillPassWithENV(?string $env, mixed $value, string $type, string $expected): void
    {
        $_ENV[$env] = $value;
        $envValue = Env::getInstance()->get($env, $type);
        $this->assertSame($expected, $envValue);
        unset($_ENV[$env]);
    }

    #[DataProvider('provider_testGetWillPass')]
    public function testGetWillPassWithSERVER(?string $env, mixed $value, string $type, string $expected): void
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
        $this->markTestIncomplete();
    }
}
