<?php

declare(strict_types=1);

namespace Freesoftde\EnvReader\Test\Types;

use Freesoftde\EnvReader\Types\BooleanType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Freesoftde\EnvReader\Types\BooleanType
 */
class BooleanTypeTest extends TestCase
{
    public static function providerTestConvert(): array
    {
        return [
            'yes' => [
                'yes',
                true,
            ],
            'YES' => [
                'YES',
                true,
            ],
            'no' => [
                'no',
                false,
            ],
            'NO' => [
                'NO',
                false,
            ],
            '0' => [
                '0',
                false,
            ],
            '1' => [
                '1',
                true,
            ],
            'true' => [
                'true',
                true,
            ],
            'false' => [
                'false',
                false,
            ],
            'TRUE' => [
                'TRUE',
                true,
            ],
            'FALSE' => [
                'FALSE',
                false,
            ],
            'on' => [
                'on',
                true,
            ],
            'off' => [
                'off',
                false,
            ],
            'ON' => [
                'ON',
                true,
            ],
            'OFF' => [
                'OFF',
                false,
            ],
        ];
    }

    /**
     * @covers ::convert
     * @param string $value
     * @param bool $expected
     * @return void
     */
    #[DataProvider('providerTestConvert')]
    public function testConvert(string $value, bool $expected): void
    {
        $value = (new BooleanType())->convert($value);
        $this->assertSame($expected, $value);
    }
}
