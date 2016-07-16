<?php declare(strict_types=1);
/**
 * Interface for token handlers
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    2.0.0
 */
namespace CodeCollab\CsrfToken;

/**
 * Interface for token handlers
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Token
{
    /**
     * Gets the token
     *
     * @return string The token
     */
    public function get(): string;

    /**
     * Generates token
     */
    public function generate();

    /**
     * Validates a supplied token
     *
     * @param string $token The supplied token
     *
     * @return bool True when the token is valid
     */
    public function isValid(string $token): bool;
}
