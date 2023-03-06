<?php

declare(strict_types=1);

namespace devcirclede\EnvReader\Test\Types;

use devcirclede\EnvReader\Exception\ConvertionException;
use devcirclede\EnvReader\Types\JsonType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \devcirclede\EnvReader\Types\JsonType
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
