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
 * @version    1.0.0
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
     * @todo Check whether internals can actually make a sane decision on handling errors
     *
     * @return string The generated token
     *
     * @throws \CodeCollabLib\CsrfToken\Generator\InsufficientStrengthException When a token with sufficient strength
     *                                                                          could not be generated
     */
    public function generate(): string
    {
        $token = @random_bytes(32);

        if ($token === false) {
            throw new InsufficientStrengthException('Could not generate a sufficientely strong token.');
        }

        return $token;
    }
}
