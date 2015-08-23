<?php declare(strict_types=1);
/**
 * Interface for token storage
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\CsrfToken\Storage;

/**
 * Interface for token storage
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Storage
{
    /**
     * Checks whether a token has been generated
     *
     * @param string $key The key of the token
     *
     * @return bool True when a token has been generated
     */
    public function exists(string $key): bool;

    /**
     * Gets the token
     *
     * @param string $key The key of the token
     *
     * @return string The token
     */
    public function get(string $key): string;

    /**
     * Sets the token
     *
     * @param string $key   The key of the token
     * @param string $token The token
     */
    public function set(string $key, string $token);
}
