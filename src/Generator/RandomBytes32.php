<?php declare(strict_types=1);
/**
 * CSRF token generator of 32 random bytes
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
 * CSRF token generator of 32 random bytes
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @package    Generator
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class RandomBytes32 implements Generator
{
    /**
     * Generates a token
     *
     * @return string The generated token
     *
     * @throws \CodeCollab\CsrfToken\Generator\InsufficientStrengthException When a token with sufficient strength
     *                                                                       could not be generated
     */
    public function generate(): string
    {
        try {
            $token = random_bytes(32);
        } catch(\Throwable $e) {
            throw new InsufficientStrengthException($e->getMessage(), $e->getCode(), $e);
        }

        return $token;
    }
}
