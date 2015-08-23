<?php declare(strict_types=1);
/**
 * Token handler
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\CsrfToken;

use CodeCollab\CsrfToken\Storage\Storage;
use CodeCollab\CsrfToken\Generator\Generator;

/**
 * Token handler
 *
 * @category   CodeCollab
 * @package    CsrfToken
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Handler implements Token
{
    /**
     * @var \CodeCollab\CsrfToken\Storage\Storage Instance of storage
     */
    private $storage;

    /**
     * @var \CodeCollab\CsrfToken\Generator\Generator Token generator implementation
     */
    private $generator;

    /**
     * Creates instance
     *
     * @param \CodeCollab\CsrfToken\Storage\Storage     $storage   Instance of storage
     * @param \CodeCollab\CsrfToken\Generator\Generator $generator Token generator implementation
     */
    public function __construct(Storage $storage, Generator $generator)
    {
        $this->storage   = $storage;
        $this->generator = $generator;
    }

    /**
     * Gets the token
     *
     * @return string The token
     */
    public function get(): string
    {
        if (!$this->storage->exists('csrfToken')) {
            $this->generate();
        }

        return $this->storage->get('csrfToken');
    }

    /**
     * Generates token
     */
    public function generate()
    {
        $this->storage->set('csrfToken', $this->generator->generate());
    }

    /**
     * Validates a supplied token
     *
     * @param string $token The supplied token
     *
     * @return bool True when the token is valid
     */
    public function isValid(string $token): bool
    {
        return hash_equals($this->get(), $token);
    }
}
