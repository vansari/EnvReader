<?php
declare(strict_types=1);

namespace Freesoftde\EnvReader\Test\Types;

use Freesoftde\EnvReader\Exception\ConvertionException;
use Freesoftde\EnvReader\Types\IntegerType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IntegerTypeTest extends TestCase
{

    public static function provider_testGet(): array
    {
        return [
            [
                '1234',
                1234,
            ],
            [
                '123.45',
                123
            ],
        ];
    }

    #[DataProvider('provider_testGet')]
    public function testGet(string $input, int $expected): void
    {
        $this->assertSame($expected, (new IntegerType())->convert($input));
    }

    public static function provider_testGetWillFail(): array
    {
        return [
            [
                'abc',
            ],
            [
                '123,45',
            ]
        ];
    }

    #[DataProvider('provider_testGetWillFail')]
    public function testGetWillFail(string $input): void
    {
        $this->expectException(ConvertionException::class);
        (new IntegerType())->convert($input);
    }
}
