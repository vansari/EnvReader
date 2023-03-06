<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Test\Types;

use DevCircleDe\EnvReader\Exception\ConvertionException;
use DevCircleDe\EnvReader\Types\IntegerType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IntegerTypeTest extends TestCase
{
    public static function providerTestGet(): array
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

    #[DataProvider('providerTestGet')]
    public function testGet(string $input, int $expected): void
    {
        $this->assertSame($expected, (new IntegerType())->convert($input));
    }

    public static function providerTestGetWillFail(): array
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

    #[DataProvider('providerTestGetWillFail')]
    public function testGetWillFail(string $input): void
    {
        $this->expectException(ConvertionException::class);
        (new IntegerType())->convert($input);
    }
}
