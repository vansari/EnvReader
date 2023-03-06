<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Test\Types;

use DevCircleDe\EnvReader\Exception\ConvertionException;
use DevCircleDe\EnvReader\Types\IntegerType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IntegerTypeTest extends TestCase
{
    public static function providerTestConvert(): array
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

    #[DataProvider('providerTestConvert')]
    public function testConvert(string $input, int $expected): void
    {
        $this->assertSame($expected, (new IntegerType())->convert($input));
    }

    public static function providerTestConvertWillFail(): array
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

    #[DataProvider('providerTestConvertWillFail')]
    public function testConvertWillFail(string $input): void
    {
        $this->expectException(ConvertionException::class);
        (new IntegerType())->convert($input);
    }
}