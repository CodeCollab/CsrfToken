# CsrfToken

CSRF token package of the CodeCollab project

[![Build Status](https://travis-ci.org/CodeCollab/CsrfToken.svg?branch=master)](https://travis-ci.org/CodeCollab/CsrfToken) [![MIT License](https://img.shields.io/badge/license-MIT-blue.svg)](mit) [![Latest Stable Version](https://poser.pugx.org/codecollab/csrf-token/v/stable)](https://packagist.org/packages/codecollab/csrf-token) [![Total Downloads](https://poser.pugx.org/codecollab/csrf-token/downloads)](https://packagist.org/packages/codecollab/csrf-token) [![Latest Unstable Version](https://poser.pugx.org/codecollab/csrf-token/v/unstable)](https://packagist.org/packages/codecollab/csrf-token)

## Requirements

PHP7+

## Installation

Include the library in your project using composer:

    {
        "require-dev": {
            "codecollab/csrf-token": "1.0.*"
        }
    }

## Usage

This library securely generates and validates CSRF tokens. To use this libray simply create a new `\CodeCollab\CsrfToken\Token` instance. A functioning concrete implementation is added as `\CodeCollab\CsrfToken\Token\Handler`:

````php
<?php

$csrfToken = new \CodeCollab\CsrfToken\Token\Handler($storage, $generator);

$theToken  = $csrfToken->get(); // this will generate a new token if it doesn't exist yet

var_dump($csrfToken->isValid($theToken)); // true
var_dump($csrfToken->isValid('invalid token')); // false
````

To generate a new token (and invalidate the old token) simply call `$csrfToken->generate()`.

````php
<?php

$csrfToken = new \CodeCollab\CsrfToken\Token\Handler($storage, $generator);

$theToken  = $csrfToken->get(); // this will generate a new token if it doesn't exist yet

var_dump($csrfToken->isValid($theToken)); // true
var_dump($csrfToken->isValid('invalid token')); // false

$csrfToken->generate();

var_dump($csrfToken->isValid($theToken)); // false
````

### Storage

This library only provides an interface for storage objects so you can use any storage you prefer. The storage must have a way to persist the token between requests (i.e. session). An example native session storage implementation may look like:

````php
<?php declare(strict_types=1);

use CodeCollab\CsrfToken\Storage\Storage;

class Session implements Storage
{
    public function exists(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function get(string $key): string
    {
        return $_SESSION[$key];
    }

    public function set(string $key, string $token)
    {
        $_SESSION[$key] = $token;
    }
}
````

All storage implementations must implement `CodeCollab\CsrfToken\Storage\Storage`.

### Generators

Generators are repsonsible for generating secure tokens. By default the `CodeCollab\CsrfToken\Generator\RandomBytes32` generator is included which as the name suggest generates a 32 bytes long random token.

This generator uses PHP's native `random_bytes()` function to generate the tokens. When a token could not be generated a `CodeCollab\CsrfToken\Generator\InsufficientStrengthException` will be thrown. The generator interface only has a single method `generate()` will generates the tokens.

The supplied generator will be fine for most cases, but if you need additional security you can implement your own generator based on the `CodeCollab\CsrfToken\Storage\Storage` interface.

## Contributing

[How to contribute][contributing]

## License

[MIT][mit]

## Security issues

If you found a security issue please contact directly by mail instead of using the issue tracker at codecollab-security@pieterhordijk.com

[contributing]: https://github.com/CodeCollab/CsrfToken/blob/master/CONTRIBUTING.md
[mit]: http://spdx.org/licenses/MIT
