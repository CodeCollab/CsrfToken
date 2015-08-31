<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\CsrfToken;

use CodeCollab\CsrfToken\Handler;

class HandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $storage = $this->getMock('CodeCollab\CsrfToken\Storage\Storage');

        $generator = $this->getMock('CodeCollab\CsrfToken\Generator\Generator');

        $this->assertInstanceOf('CodeCollab\CsrfToken\Token', new Handler($storage, $generator));
    }

    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     * @covers CodeCollab\CsrfToken\Token::get
     */
    public function testGetAlreadyExists()
    {
        $storage = $this->getMock('CodeCollab\CsrfToken\Storage\Storage');

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

        $generator = $this->getMock('CodeCollab\CsrfToken\Generator\Generator');

        $this->assertSame('TheToken', (new Handler($storage, $generator))->get());
    }

    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     * @covers CodeCollab\CsrfToken\Token::generate
     * @covers CodeCollab\CsrfToken\Token::get
     */
    public function testGetBeingGenerated()
    {
        $storage = $this->getMock('CodeCollab\CsrfToken\Storage\Storage');

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

        $generator = $this->getMock('CodeCollab\CsrfToken\Generator\Generator');

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
        $storage = $this->getMock('CodeCollab\CsrfToken\Storage\Storage');

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

        $generator = $this->getMock('CodeCollab\CsrfToken\Generator\Generator');

        $this->assertFalse((new Handler($storage, $generator))->isValid('not valid'));
    }

    /**
     * @covers CodeCollab\CsrfToken\Handler::__construct
     * @covers CodeCollab\CsrfToken\Token::isValid
     */
    public function testIsValidValid()
    {
        $storage = $this->getMock('CodeCollab\CsrfToken\Storage\Storage');

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

        $generator = $this->getMock('CodeCollab\CsrfToken\Generator\Generator');

        $this->assertTrue((new Handler($storage, $generator))->isValid('TheToken'));
    }
}
