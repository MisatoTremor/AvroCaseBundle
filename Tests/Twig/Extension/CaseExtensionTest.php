<?php

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Avro\CaseBundle\Tests\Twig\Extension;

use Avro\CaseBundle\Twig\Extension\CaseExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFilter;

/**
 * Test CaseExtension Class.
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class CaseExtensionTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Avro\CaseBundle\Util\CaseConverter
     */
    protected $converter;
    /**
     * @var CaseExtension
     */
    protected $extension;

    public function setup(): void
    {
        $this->converter = $this->createMock('Avro\CaseBundle\Util\CaseConverter');
        $this->extension = new CaseExtension($this->converter);
    }

    /**
     * @covers \Avro\CaseBundle\Twig\Extension\CaseExtension::getName
     */
    public function testGetName()
    {
        $this->assertSame('CaseExtension', $this->extension->getName());
    }

    /**
     * @covers \Avro\CaseBundle\Twig\Extension\CaseExtension::getFilters
     */
    public function testGetFilters()
    {
        $functions = $this->extension->getFilters();
        $this->assertContainsOnly(TwigFilter::class, $functions);
    }

    public function testCamelCase()
    {
        $this->converter
            ->method('toCamelCase')
            ->willReturn('camelCase');
        $this->assertEquals(
            'camelCase',
            $this->extension->toCamelCase('camel case')
        );
    }

    public function testKebabCase()
    {
        $this->converter
            ->method('toKebabCase')
            ->willReturn('kebab-case');
        $this->assertEquals(
            'kebab-case',
            $this->extension->toKebabCase('kebab case')
        );
    }

    public function testPascalCase()
    {
        $this->converter
            ->method('toPascalCase')
            ->willReturn('PascalCase');
        $this->assertEquals(
            'PascalCase',
            $this->extension->toPascalCase('pascal_case')
        );
    }

    public function testTitleCase()
    {
        $this->converter
            ->method('toTitleCase')
            ->willReturn('Title Case');
        $this->assertEquals(
            'Title Case',
            $this->extension->toTitleCase('title_case')
        );
    }

    public function testUnderscoreCase()
    {
        $this->converter
            ->method('toUnderscoreCase')
            ->willReturn('underscore_case');
        $this->assertEquals(
            'underscore_case',
            $this->extension->toUnderscoreCase('underscore case')
        );
    }
}
