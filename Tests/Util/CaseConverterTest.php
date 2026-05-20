<?php

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Avro\CaseBundle\Tests\Util;

use Avro\CaseBundle\Util\CaseConverter;
use PHPUnit\Framework\TestCase;
use stdClass;

class CaseConverterTest extends TestCase
{
    private CaseConverter $converter;

    public function setUp(): void
    {
        $this->converter = new CaseConverter();
    }

    public function unsupportedProvider(): array
    {
        $object = new stdClass();

        return [
            [null, null], // Unsupported value
            [123456, 123456], // Unsupported value
            [1.42, 1.42], // Unsupported value
            [$object, $object], // Unsupported value
            [[], []], // Unsupported value
            [[123456, 1.42], [123456, 1.42]], // Array
        ];
    }

    public function titleCaseProvider(): array
    {
        return [
            ['titlecaseformat', 'Titlecaseformat'], // All lower case
            ['TITLECASEFORMAT', 'T I T L E C A S E F O R M A T'], // All upper case
            ['Title Case Format', 'Title Case Format'], // Title
            ['titleCaseFormat', 'Title Case Format'], // Title
            ['TitleCaseFormat', 'Title Case Format'], // Title
            ['title_case_format', 'Title Case Format'], // Title
            ['title case format', 'Title Case Format'], // Words
            [['title case format', 'title_case_format'], ['Title Case Format', 'Title Case Format']], // Array
        ];
    }

    public function camelCaseProvider(): array
    {
        return [
            ['camelcaseformat', 'camelcaseformat'], // All lower case
            ['CAMELCASEFORMAT', 'cAMELCASEFORMAT'], // All upper case
            ['Camel Case Format', 'camelCaseFormat'], // Title
            ['camelCaseFormat', 'camelCaseFormat'], // Camel
            ['CamelCaseFormat', 'camelCaseFormat'], // Camel
            ['camel_case_format', 'camelCaseFormat'], // Camel
            ['camel case format', 'camelCaseFormat'], // Words
            [['camel case format', 'camel_case_format'], ['camelCaseFormat', 'camelCaseFormat']], // Array
        ];
    }

    public function kebabCaseProvider(): array
    {
        return [
            ['kebabcaseformat', 'kebabcaseformat'], // All lower case
            ['KEBABCASEFORMAT', 'k-e-b-a-b-c-a-s-e-f-o-r-m-a-t'], // All upper case
            ['Kebab Case Format', 'kebab-case-format'], // Title
            ['kebabCaseFormat', 'kebab-case-format'], // Camel
            ['KebabCaseFormat', 'kebab-case-format'], // Kebab
            ['kebab_case_format', 'kebab-case-format'], // Kebab
            ['kebab case format', 'kebab-case-format'], // Words
            [['kebab case format', 'kebab-case-format'], ['kebab-case-format', 'kebab-case-format']], // Array
        ];
    }

    public function pascalCaseProvider(): array
    {
        return [
            ['pascalcaseformat', 'Pascalcaseformat'], // All lower case
            ['PASCALCASEFORMAT', 'PASCALCASEFORMAT'], // All upper case
            ['Pascal Case Format', 'PascalCaseFormat'], // Title
            ['pascalCaseFormat', 'PascalCaseFormat'], // Camel
            ['PascalCaseFormat', 'PascalCaseFormat'], // Pascal
            ['pascal_case_format', 'PascalCaseFormat'], // Underscore
            ['pascal case format', 'PascalCaseFormat'], // Words
            [['pascal case format', 'pascal_case_format'], ['PascalCaseFormat', 'PascalCaseFormat']], // Array
        ];
    }

    public function underscoreCaseProvider(): array
    {
        return [
            ['underscorecaseformat', 'underscorecaseformat'], // All lower case
            ['UNDERSCORECASEFORMAT', 'u_n_d_e_r_s_c_o_r_e_c_a_s_e_f_o_r_m_a_t'], // All upper case
            ['Underscore Case Format', 'underscore_case_format'], // Title
            ['underscoreCaseFormat', 'underscore_case_format'], // Camel
            ['UnderscoreCaseFormat', 'underscore_case_format'], // Underscore
            ['underscore_case_format', 'underscore_case_format'], // Underscore
            ['underscore case format', 'underscore_case_format'], // Words
            [['underscore case format', 'underscore_case_format'], ['underscore_case_format', 'underscore_case_format']], // Array
        ];
    }

    /**
     * @dataProvider unsupportedProvider
     * @dataProvider titleCaseProvider
     */
    public function testToTitleCase($source, $expected): void
    {
        $this->assertSame(
            $expected,
            $this->converter->toTitleCase($source)
        );
    }

    /**
     * @dataProvider unsupportedProvider
     * @dataProvider camelCaseProvider
     */
    public function testToCamelCase($source, $expected): void
    {
        $this->assertSame(
            $expected,
            $this->converter->toCamelCase($source)
        );
    }

    /**
     * @dataProvider unsupportedProvider
     * @dataProvider kebabCaseProvider
     */
    public function testToKebabCase($source, $expected): void
    {
        $this->assertSame(
            $expected,
            $this->converter->toKebabCase($source)
        );
    }

    /**
     * @dataProvider unsupportedProvider
     * @dataProvider pascalCaseProvider
     */
    public function testToPascalCase($source, $expected): void
    {
        $this->assertSame(
            $expected,
            $this->converter->toPascalCase($source)
        );
    }

    /**
     * @dataProvider unsupportedProvider
     * @dataProvider underscoreCaseProvider
     */
    public function testToUnderscoreCase($source, $expected): void
    {
        $this->assertSame(
            $expected,
            $this->converter->toUnderscoreCase($source)
        );
    }

    public function testConvert()
    {
        $this->assertSame(
            'underscore_case_format',
            $this->converter->convert('underscoreCaseFormat', 'underscore')
        );
        $this->assertSame(
            'kebab-case-format',
            $this->converter->convert('kebabCaseFormat', 'kebab')
        );
        $this->assertSame(
            'camelCaseFormat',
            $this->converter->convert('camel Case Format', 'camel')
        );
        $this->assertSame(
            'PascalCaseFormat',
            $this->converter->convert('pascal_case_format', 'pascal')
        );
        $this->assertSame(
            'Title Case Format',
            $this->converter->convert('title case format', 'title')
        );
    }

    public function testArrayArguments(): void
    {
        $this->assertSame(
            [
                'foo' => 'Title Case Format1',
                'bar' => [
                    'Title Case Format2',
                    'Title Case Format3',
                ],
                'baz' => 'Title Case Format4',
            ],
            $this->converter->convert(
                [
                    'foo' => 'Title Case Format1',
                    'bar' => [
                        'title_case_format2',
                        'title case format3',
                    ],
                    'baz' => 'titleCaseFormat4',
                ],
                'title'
            )
        );
        $this->assertSame(
            [
                'foo' => 'underscore_case_format1',
                'bar' => [
                    'underscore_case_format2',
                    'underscore_case_format3',
                ],
            ],
            $this->converter->convert(
                [
                    'foo' => 'underscoreCaseFormat1',
                    'bar' => [
                        'underscore_case_format2',
                        'Underscore Case Format3',
                    ],
                ],
                'underscore'
            )
        );
        $this->assertSame(
            [
                'foo' => 'kebab-case-format1',
                'bar' => [
                    'kebab-case-format2',
                    'kebab-case-format3',
                ],
            ],
            $this->converter->convert(
                [
                    'foo' => 'kebabCaseFormat1',
                    'bar' => [
                        'kebab-case-format2',
                        'Kebab Case Format3',
                    ],
                ],
                'kebab'
            )
        );
        $this->assertSame(
            [
                'foo' => 'camelCaseFormat1',
                'bar' => [
                    'camelCaseFormat2',
                    'camelCaseFormat3',
                ],
            ],
            $this->converter->convert(
                [
                    'foo' => 'camelCaseFormat1',
                    'bar' => [
                        'camel_case_format2',
                        'camel Case Format3',
                    ],
                ],
                'camel'
            )
        );
        $this->assertSame(
            [
                'foo' => 'PascalCaseFormat1',
                'bar' => [
                    'PascalCaseFormat2',
                    'PascalCaseFormat3',
                ],
                'baz' => 'PascalCaseFormat4',
            ],
            $this->converter->convert(
                [
                    'foo' => 'PascalCaseFormat1',
                    'bar' => [
                        'pascal_case_format2',
                        'pascal case format3',
                    ],
                    'baz' => 'Pascal Case Format4',
                ],
                'pascal'
            )
        );
    }

    public function testGetFormat()
    {
        $this->assertSame(
            'underscore',
            $this->converter->getFormat('underscore_case_format')
        );

        $this->assertSame(
            'kebab',
            $this->converter->getFormat('underscore-case-format')
        );

        $this->assertSame(
            'camel',
            $this->converter->getFormat('camelCaseFormat')
        );

        $this->assertSame(
            'pascal',
            $this->converter->getFormat('PascalCaseFormat')
        );

        $this->assertSame(
            'title',
            $this->converter->getFormat('Title Case Format')
        );
    }
}
