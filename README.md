AvroCaseBundle [![Build Status](https://github.com/MisatoTremor/AvroCaseBundle/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/MisatoTremor/AvroCaseBundle) [![codecov](https://codecov.io/gh/MisatoTremor/AvroCaseBundle/branch/1.0.x/graph/badge.svg?token=6MSH5913H0)](https://codecov.io/gh/MisatoTremor/AvroCaseBundle)
--------------
Convert strings or strings in arrays to different case formats.

Supports: camelCase, kebab-case, PascalCase, Title Case, and underscore_case.

This is a fork of jdewits [original code](https://github.com/jdewit/AvroCaseBundle).

Installation
------------
This bundle is listed on packagist.

Download the bundle

```shell
$ composer require misatotremor/case-bundle
```

Enable the bundle

```php
<?php
// config/bundles.php

return [
    // ...
    Avro\CaseBundle\AvroCaseBundle::class => ['all' => true],
    // ...
];
```

Configuration
-------------

*Optional:* Add this config

```yaml
# config/packages/avro_case.yaml
avro_case:
    use_twig: false #disable the twig extension (true by default)
```

Usage
-----
```php
<?php
use Avro\CaseBundle\Util\CaseConverter;

class SomeClass
{
    private $caseConverter;

    /**
     * @param CaseConverter $caseConverter
     */
    public function __construct(CaseConverter $caseConverter)
    {
        $this->caseConverter = $caseConverter;
    }

    /**
     * @param string $str
     */
    public function foo(string $str)
    {
        $camelCaseFormat = $this->converter->toCamelCase($str);
        $kebabCaseFormat = $this->converter->toKebabCase($str);
        $pascalCaseFormat = $this->converter->toPascalCase($str);
        $titleCaseFormat = $this->converter->toTitleCase($str);
        $underscoreCaseFormat = $this->converter->toUnderscoreCase($str);
    }
}
```

The following filters are also available if you use Twig

```twig
    {{ var | camel }}
    {{ var | kebab }}
    {{ var | pascal }}
    {{ var | title }}
    {{ var | underscore }}
```


