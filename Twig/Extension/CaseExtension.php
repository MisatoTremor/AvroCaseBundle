<?php

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Avro\CaseBundle\Twig\Extension;

use Avro\CaseBundle\Util\CaseConverter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Twig extension for case conversion.
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class CaseExtension extends AbstractExtension
{
    protected CaseConverter $caseConverter;

    public function __construct(CaseConverter $caseConverter)
    {
        $this->caseConverter = $caseConverter;
    }

    /**
     * Get twig filters.
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('camel', [$this, 'toCamelCase']),
            new TwigFilter('kebab', [$this, 'toKebabCase']),
            new TwigFilter('pascal', [$this, 'toPascalCase']),
            new TwigFilter('underscore', [$this, 'toUnderscoreCase']),
            new TwigFilter('title', [$this, 'toTitleCase']),
        ];
    }

    /**
     * Convert string to camel case format.
     *
     * @param string|array|null $input
     *
     * @return string|array|null In camel case
     */
    public function toCamelCase($input)
    {
        return $this->caseConverter->toCamelCase($input);
    }

    /**
     * Convert string to kebab case format.
     *
     * @param string|array|null $input
     *
     * @return string|array|null In kebab case
     */
    public function toKebabCase($input)
    {
        return $this->caseConverter->toKebabCase($input);
    }

    /**
     * Convert string to pascal case format.
     *
     * @param string|array|null $input
     *
     * @return string|array|null In pascal case
     */
    public function toPascalCase($input)
    {
        return $this->caseConverter->toPascalCase($input);
    }

    /**
     * Convert string to underscore case format.
     *
     * @param string|array|null $input
     *
     * @return string|array|null In underscore case
     */
    public function toUnderscoreCase($input)
    {
        return $this->caseConverter->toUnderscoreCase($input);
    }

    /**
     * Convert string to title case format.
     *
     * @param string|array|null $input
     *
     * @return string|array|null In title case
     */
    public function toTitleCase($input)
    {
        return $this->caseConverter->toTitleCase($input);
    }

    /**
     * Get twig extension name.
     */
    public function getName(): string
    {
        return 'CaseExtension';
    }
}
