# EnvReader

### PHP Environment Reader

Simple Environment Reader which can parse the Value to a specific type. It tries to find the Value in $_ENV, $_SERVER and via getenv. The logic is leaned on the [EnvVarProcessor](https://github.com/symfony/symfony/blob/6.2/src/Symfony/Component/DependencyInjection/EnvVarProcessor.php) from Symfony.

Actual included Types are:

- integer
- float
- string
- boolean

You can add your own Type by creating a class which implements the TypeInterface.

Example:
```php
<?php

declare(strict_types=1);

namespace Company\EnvTypes;

use devcirclede\EnvReader\Types\TypeInterface;

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
use devcirclede\EnvReader\Env;

$env = Env::getInstance();
// add custom type
$env->getCollection()->addItem(new CustomType());

// read Env
$var = $env->get('FOO', 'custom_type');

```
