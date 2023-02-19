<?php
declare(strict_types=1);

namespace Freesoftde\EnvReader\Test\Types;

use Freesoftde\EnvReader\Types\StringType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StringTypeTest extends TestCase
{

    public static function provider_testGet(): array
    {
        // Todo: More TestCases
        return [
            ['text', 'text'],
            [12345, '12345'],
            [123.56, '123.56'],
            [
                new class implements \Stringable
                {
                    public function __toString(): string
                    {
                        return 'anonymous';
                    }
                },
                'anonymous'
            ]
        ];
    }

    #[DataProvider('provider_testGet')]
    public function testGet(mixed $input, string $expected): void
    {
        $this->assertSame($expected, (new StringType())->convert($input));
    }
}
