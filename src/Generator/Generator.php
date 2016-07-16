<?php declare(strict_types=1);
/**
 * CSRF token generator interface
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @package    Generator
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    2.0.0
 */
namespace CodeCollab\CsrfToken\Generator;

/**
 * CSRF token generator interface
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @package    Generator
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Generator
{
    /**
     * Generates a token
     *
     * @todo Check whether internals can actually make a sane decision on handling errors
     *
     * @return string The generated token
     *
     * @throws \CodeCollab\CsrfToken\Generator\InsufficientStrengthException When a token with sufficient strength
     *                                                                       could not be generated
     */
    public function generate(): string;
}
