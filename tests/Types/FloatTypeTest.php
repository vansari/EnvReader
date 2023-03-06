<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Test\Types;

use DevCircleDe\EnvReader\Exception\ConvertionException;
use DevCircleDe\EnvReader\Types\FloatType;
use DevCircleDe\EnvReader\Types\TypeCollection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FloatTypeTest extends TestCase
{
    public static function providerTestGet(): array
    {
        return [
            [
                '123.45',
                123.45
            ],
            [
                '1000',
                1000.00
            ],
            [
                '0.1234',
                0.1234
            ]
        ];
    }

    #[DataProvider('providerTestGet')]
    public function testGet(string $value, float $expected): void
    {
        $this->assertSame($expected, (new FloatType())->convert($value));
    }

    public function testGetWillFail(): void
    {
        $this->expectException(ConvertionException::class);
        (new FloatType())->convert('abcdef');
    }
}
