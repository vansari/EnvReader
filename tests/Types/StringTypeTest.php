<?php

declare(strict_types=1);

namespace devcirclede\EnvReader\Test\Types;

use devcirclede\EnvReader\Types\StringType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StringTypeTest extends TestCase
{
    public static function providerTestGet(): array
    {
        // Todo: More TestCases
        return [
            ['text', 'text'],
            ['12345', '12345'],
            ['123.56', '123.56'],
        ];
    }

    #[DataProvider('providerTestGet')]
    public function testConvert(mixed $input, string $expected): void
    {
        $this->assertSame($expected, (new StringType())->convert($input));
    }
}
