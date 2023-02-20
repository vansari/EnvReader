<?php
declare(strict_types=1);

namespace Freesoftde\EnvReader\Test\Types;

use Freesoftde\EnvReader\Exception\KeyInUseException;
use Freesoftde\EnvReader\Exception\NotFoundException;
use Freesoftde\EnvReader\Types\FloatType;
use Freesoftde\EnvReader\Types\IntegerType;
use Freesoftde\EnvReader\Types\StringType;
use Freesoftde\EnvReader\Types\TypeCollection;
use Freesoftde\EnvReader\Types\TypeInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Freesoftde\EnvReader\Types\TypeCollection
 */
class TypeCollectionTest extends TestCase
{

    public function testConstruct(): void
    {
        $collection = new TypeCollection(new StringType(), new IntegerType());
        $this->assertCount(2, $collection->getKeys());
    }

    public function testConstructWithUnpack(): void
    {
        $types = [new StringType(), new IntegerType(),];
        $collection = new TypeCollection(...$types);
        $this->assertCount(2, $collection->getKeys());
    }

    public function testConstructWillFailWithDuplicateTypes(): void
    {
        $types = [new StringType(), new IntegerType(), new StringType(),];
        $this->expectException(KeyInUseException::class);
        new TypeCollection(...$types);
    }

    public static function provider_items(): array
    {
        return [
            'Add three Types without overwrite' => [
                [new StringType(), new IntegerType(), new FloatType()],
                false,
                3,
            ],
            'Add three Types with overwrite and one duplicate' => [
                [new StringType(), new IntegerType(), new StringType(), new FloatType()],
                true,
                3,
            ]
        ];
    }

    /**
     * @param TypeInterface[] $types
     * @param bool $overwrite
     * @param int $expectedCount
     * @throws KeyInUseException
     * @covers ::addItem
     */
    #[DataProvider('provider_items')]
    public function testAddItem(array $types, bool $overwrite, int $expectedCount): void
    {
        $collection = new TypeCollection();
        foreach ($types as $type) {
            $collection->addItem($type, $overwrite);
        }
        $this->assertCount($expectedCount, $collection->getKeys());
    }

    public function testAddItemWillFailIfKeyExistsAndNotOverwrite(): void
    {
        $collection = new TypeCollection();
        $collection->addItem(new StringType());
        $collection->addItem(new IntegerType());
        $this->expectException(KeyInUseException::class);
        $collection->addItem(new StringType());
    }

    /**
     * @param TypeInterface[] $types
     * @param bool $overwrite
     * @param int $expectedCount
     * @throws KeyInUseException
     * @covers ::getItem
     */
    #[DataProvider('provider_items')]
    public function testGetItem(array $types, bool $overwrite, int $expectedCount): void
    {
        $collection = new TypeCollection();
        $addedTypes = [];
        foreach ($types as $type) {
            $addedTypes[] = $type->getName();
            $collection->addItem($type, $overwrite);
        }

        $this->assertCount($expectedCount, $collection->getKeys());

        foreach ($addedTypes as $addedType) {
            $getItem = $collection->getItem($addedType);
            $this->assertSame($addedType, $getItem->getName());
        }
    }

    public function testGetItemWillFailIfRequestedKeyNotExists(): void
    {
        $collection = new TypeCollection();
        $collection->addItem(new StringType());
        $this->expectException(NotFoundException::class);
        $collection->getItem('json');
    }

    /**
     * @param TypeInterface[] $types
     * @param bool $overwrite
     * @param int $expectedCount
     * @throws KeyInUseException
     * @covers ::getKeys
     */
    #[DataProvider('provider_items')]
    public function testGetKeys(array $types, bool $overwrite, int $expectedCount): void
    {
        $addedKeys = [];
        $collection = new TypeCollection();
        foreach ($types as $type) {
            $addedKeys[] = $type->getName();
            $collection->addItem($type, $overwrite);
        }
        $this->assertCount($expectedCount, $collection->getKeys());
        $this->assertSame(array_values(array_unique($addedKeys)), $collection->getKeys());
    }
}
