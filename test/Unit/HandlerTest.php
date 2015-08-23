<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\CsrfToken;

use CodeCollab\CsrfToken\Storage\Storage;
use CodeCollab\CsrfToken\Generator\Generator;
use CodeCollab\CsrfToken\Handler;

class HandlerTest extends \PHPUnit_Framework_TestCase// implements Token
{
    /**
     * @covers CodeCollab\CsrfToken\Token::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $storage = (new class implements Storage {
            public function exists(string $key): bool {}

            public function get(string $key): string {}

            public function set(string $key, string $token) {}
        });

        $generator = (new class implements Generator {
            public function generate(): string {}
        });

        $this->assertInstanceOf('CodeCollab\CsrfToken\Token', new Handler($storage, $generator));
    }

    /**
     * @covers CodeCollab\CsrfToken\Token::__construct
     * @covers CodeCollab\CsrfToken\Token::get
     */
    public function testGetAlreadyExists()
    {
        $storage = (new class implements Storage {
            public function exists(string $key): bool {
                return true;
            }

            public function get(string $key): string {
                return $key;
            }

            public function set(string $key, string $token) {}
        });

        $generator = (new class implements Generator {
            public function generate(): string {}
        });

        $this->assertSame('csrfToken', (new Handler($storage, $generator))->get());
    }

    /**
     * @covers CodeCollab\CsrfToken\Token::__construct
     * @covers CodeCollab\CsrfToken\Token::generate
     * @covers CodeCollab\CsrfToken\Token::get
     */
    public function testGetBeingGenerated()
    {
        $storage = (new class implements Storage {
            public function exists(string $key): bool {
                return false;
            }

            public function get(string $key): string {
                return $key;
            }

            public function set(string $key, string $token) {
                \PHPUnit_Framework_Assert::assertSame('csrfToken', $key);
                \PHPUnit_Framework_Assert::assertSame('generatedtoken', $token);
            }
        });

        $generator = (new class implements Generator {
            public function generate(): string {
                return 'generatedtoken';
            }
        });

        $this->assertSame('csrfToken', (new Handler($storage, $generator))->get());
    }

    /**
     * @covers CodeCollab\CsrfToken\Token::__construct
     * @covers CodeCollab\CsrfToken\Token::isValid
     */
    public function testIsValidNotValid()
    {
        $storage = (new class implements Storage {
            public function exists(string $key): bool {
                return true;
            }

            public function get(string $key): string {
                return $key;
            }

            public function set(string $key, string $token) {}
        });

        $generator = (new class implements Generator {
            public function generate(): string {}
        });

        $this->assertFalse('csrfToken', (new Handler($storage, $generator))->isValid('not valid'));
    }

    /**
     * @covers CodeCollab\CsrfToken\Token::__construct
     * @covers CodeCollab\CsrfToken\Token::isValid
     */
    public function testIsValidValid()
    {
        $storage = (new class implements Storage {
            public function exists(string $key): bool {
                return true;
            }

            public function get(string $key): string {
                return $key;
            }

            public function set(string $key, string $token) {}
        });

        $generator = (new class implements Generator {
            public function generate(): string {}
        });

        $this->assertTrue('csrfToken', (new Handler($storage, $generator))->isValid('csrfToken'));
    }
}
