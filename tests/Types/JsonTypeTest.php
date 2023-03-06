<?php

declare(strict_types=1);

namespace DevCircleDe\EnvReader\Test\Types;

use DevCircleDe\EnvReader\Exception\ConvertionException;
use DevCircleDe\EnvReader\Types\JsonType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DevCircleDe\EnvReader\Types\JsonType
 */
class JsonTypeTest extends TestCase
{
    public static function providerTestConvert(): array
    {
        return [
            [
                '{}',
                [],
            ],
            [
                '{"foo": "bar", "baz": 123.45}',
                ["foo" => "bar", "baz" => 123.45],
            ],
        ];
    }

    #[DataProvider('providerTestConvert')]
    public function testConvert(string $input, array $expected): void
    {
        $this->assertSame($expected, (new JsonType())->convert($input));
    }

    public function testConvertWillFail(): void
    {
        $this->expectException(ConvertionException::class);
        (new JsonType())->convert('');
    }
}
