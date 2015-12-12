<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\CsrfToken\Generator;

use CodeCollab\CsrfToken\Generator\RandomBytes32;

class RandomBytes32Test extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf(
            'CodeCollab\CsrfToken\Generator\Generator',
            new RandomBytes32($this->getMock('CodeCollabLib\CsrfToken\Storage\Storage'))
        );
    }

    /**
     * @covers CodeCollab\CsrfToken\Generator\RandomBytes32::generate
     */
    public function testGenerateCorrect()
    {
        $this->assertSame(
            32,
            strlen((new RandomBytes32($this->getMock('CodeCollabLib\CsrfToken\Storage\Storage')))->generate())
        );
    }

    /**
     * @covers CodeCollab\CsrfToken\Generator\RandomBytes32::generate
     */
    public function testGenerateReturnsToken()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('random_bytes');

        uopz_function('random_bytes', function(int $length){
            return 'generatedtoken' . $length;
        });

        $this->assertSame(
            'generatedtoken32',
            (new RandomBytes32($this->getMock('CodeCollabLib\CsrfToken\Storage\Storage')))->generate()
        );

        uopz_restore('random_bytes');
    }

    /**
     * @covers CodeCollab\CsrfToken\Generator\RandomBytes32::generate
     */
    public function testGenerateNoAppropriateSourceOfRandomness()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('random_bytes');

        uopz_function('random_bytes', function(){
            throw new \Exception('badsource', 1);
        });

        $this->setExpectedException(
            'CodeCollabLib\CsrfToken\Generator\InsufficientStrengthException',
            'Could not generate a sufficientely strong token.',
            1
        );

        (new RandomBytes32($this->getMock('CodeCollabLib\CsrfToken\Storage\Storage')))->generate();

        uopz_restore('random_bytes');
    }

    /**
     * @covers CodeCollab\CsrfToken\Generator\RandomBytes32::generate
     */
    public function testGenerateInvalidParameters()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('random_bytes');

        uopz_function('random_bytes', function(){
            throw new \TypeError('invalidparams', 2);
        });

        $this->setExpectedException(
            'CodeCollabLib\CsrfToken\Generator\InsufficientStrengthException',
            'Could not generate a sufficientely strong token.',
            2
        );

        (new RandomBytes32($this->getMock('CodeCollabLib\CsrfToken\Storage\Storage')))->generate();

        uopz_restore('random_bytes');
    }

    /**
     * @covers CodeCollab\CsrfToken\Generator\RandomBytes32::generate
     */
    public function testGenerateInvalidLengthOfBytes()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('random_bytes');

        uopz_function('random_bytes', function(){
            throw new \Error('invalidlength', 3);
        });

        $this->setExpectedException(
            'CodeCollabLib\CsrfToken\Generator\InsufficientStrengthException',
            'Could not generate a sufficientely strong token.',
            3
        );

        (new RandomBytes32($this->getMock('CodeCollabLib\CsrfToken\Storage\Storage')))->generate();

        uopz_restore('random_bytes');
    }
}
