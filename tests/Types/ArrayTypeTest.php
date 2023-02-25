<?php
declare(strict_types=1);

namespace devcirclede\EnvReader\Test\Types;

use devcirclede\EnvReader\Exception\ConvertionException;
use devcirclede\EnvReader\Types\ArrayType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \\${TESTED_NAMESPACE}\\${TESTED_NAME}
 */
class ArrayTypeTest extends TestCase
{
    public static function providerTestConvert(): array
    {
        return [
            'empty Array' => [
                '[]',
                [],
            ],
            'numeric Array' => [
                '[1,2,3,4,5]',
                [1,2,3,4,5],
            ],
            'string Array' => [
                '[a,b,c,d,e]',
                ['a', 'b', 'c', 'd', 'e'],
            ],
            'mixed Array' => [
                '[a,123,c,456,e]',
                ['a', 123, 'c', 456, 'e'],
            ],
            'Array with whitespace' => [
                '[a,   123   ,   c,  45 6, e]',
                ['a', 123, 'c', '45 6', 'e'],
            ],
        ];
    }

    #[DataProvider('providerTestConvert')]
    public function testConvert(string $input, array $expected): void
    {
        $value = (new ArrayType())->convert($input);
        $this->assertEquals($expected, $value);
    }

    public static function providerTestConvertWillFailWithInvalidValues(): array
    {
        return [
            [
                '',
            ],
            [
                '[',
            ],
            [
                '{}',
            ],
            [
                '1,2,3,4',
            ],
        ];
    }

    #[DataProvider('providerTestConvertWillFailWithInvalidValues')]
    public function testConvertWillFailWithInvalidValues(string $input): void
    {
        $this->expectException(ConvertionException::class);
        (new ArrayType())->convert($input);
    }
}
