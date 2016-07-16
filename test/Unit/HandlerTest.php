<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\CsrfToken;

use CodeCollab\CsrfToken\Handler;
use CodeCollab\CsrfToken\Storage\Storage;
use CodeCollab\CsrfToken\Generator\Generator;
use CodeCollab\CsrfToken\Token;

class HandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $storage   = $this->createMock(Storage::class);
        $generator = $this->createMock(Generator::class);

        $this->assertInstanceOf(Token::class, new Handler($storage, $generator));
    }

    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     * @covers CodeCollab\CsrfToken\Token::get
     */
    public function testGetAlreadyExists()
    {
        $storage = $this->createMock(Storage::class);

        $storage
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('csrfToken'))
            ->willReturn(true)
        ;

        $storage
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('csrfToken'))
            ->willReturn('TheToken')
        ;

        $generator = $this->createMock(Generator::class);

        $this->assertSame('TheToken', (new Handler($storage, $generator))->get());
    }

    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     * @covers CodeCollab\CsrfToken\Token::generate
     * @covers CodeCollab\CsrfToken\Token::get
     */
    public function testGetBeingGenerated()
    {
        $storage = $this->createMock(Storage::class);

        $storage
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('csrfToken'))
            ->willReturn(false)
        ;

        $storage
            ->expects($this->once())
            ->method('set')
            ->with($this->equalTo('csrfToken'), $this->equalTo('generatedtoken'))
            ->willReturn('TheToken')
        ;

        $storage
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('csrfToken'))
            ->willReturn('TheToken')
        ;

        $generator = $this->createMock(Generator::class);

        $generator
            ->expects($this->once())
            ->method('generate')
            ->willReturn('generatedtoken')
        ;

        $this->assertSame('TheToken', (new Handler($storage, $generator))->get());
    }

    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     * @covers CodeCollab\CsrfToken\Token::isValid
     */
    public function testIsValidNotValid()
    {
        $storage = $this->createMock(Storage::class);

        $storage
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('csrfToken'))
            ->willReturn(true)
        ;

        $storage
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('csrfToken'))
            ->willReturn('TheToken')
        ;

        $generator = $this->createMock(Generator::class);

        $this->assertFalse((new Handler($storage, $generator))->isValid('not valid'));
    }

    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     * @covers CodeCollab\CsrfToken\Token::isValid
     */
    public function testIsValidValid()
    {
        $storage = $this->createMock(Storage::class);

        $storage
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('csrfToken'))
            ->willReturn(true)
        ;

        $storage
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('csrfToken'))
            ->willReturn('TheToken')
        ;

        $generator = $this->createMock(Generator::class);

        $this->assertTrue((new Handler($storage, $generator))->isValid('TheToken'));
    }
}
