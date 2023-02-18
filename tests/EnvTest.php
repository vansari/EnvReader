<?php
declare(strict_types=1);

namespace Freesoftde\EnvReader\Test;

use Freesoftde\EnvReader\Env;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{

    public function provider_testGetWillPass(): array
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
    public function testGetWillPass(string $env, mixed $value, string $type, string $expected): void
    {
        putenv("$env=$value");
        $envValue = Env::getInstance()->get($env, $type);
        $this->assertSame($expected, $envValue);
        putenv($env);
    }

    public function testGetWillFail(): void
    {

    }
}
