<img src="https://img.shields.io/github/v/release/devcircle-de/EnvReader.svg" /> ![workflow](https://github.com/devcircle-de/EnvReader/actions/workflows/php.yml/badge.svg) <a href="https://play.phpsandbox.io/devcirclede/env-reader"><img src="https://img.shields.io/badge/Test%20package%20on-play.phpsandbox.io-blue.svg" /></a> 
# EnvReader

### PHP Environment Reader

Simple Environment Reader which can parse the Value to a specific type. It tries to find the Value in $_ENV, $_SERVER and via getenv. The logic is leaned on the [EnvVarProcessor](https://github.com/symfony/symfony/blob/6.2/src/Symfony/Component/DependencyInjection/EnvVarProcessor.php) from Symfony.

### Installation

```shell
composer require devcirclede/env-reader
```

### Supported Types

Actual included Types are:

- integer
- float
- string
- boolean
- array
- json

You can add your own Type by creating a class which implements the TypeInterface.

Example:
```php
<?php

declare(strict_types=1);

namespace Company\EnvTypes;

use DevCircleDe\EnvReader\Types\TypeInterface;

class CustomType implements TypeInterface
{
    public function getName(): string
    {
        return 'custom';
    }
    
    public function convert(string $value): mixed
    {
        // convert the value to custom type
        return $value;
    }
}
```

Usage of the CustomType:

```php
<?php

use Company\EnvTypes\CustomType;
use DevCircleDe\EnvReader\EnvParser;

$envParser = EnvParser::getInstance();
// add custom type
$envParser->getCollection()->addItem(new CustomType());

// read Env
$var = $envParser->parse('FOO', 'custom_type');

```
