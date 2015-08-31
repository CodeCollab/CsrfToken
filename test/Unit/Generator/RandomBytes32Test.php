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

        $this->setExpectedException('CodeCollabLib\CsrfToken\Generator\InsufficientStrengthException');

        $this->assertSame(
            'generatedtoken32',
            (new RandomBytes32($this->getMock('CodeCollabLib\CsrfToken\Storage\Storage')))->generate()
        );

        uopz_restore('random_bytes');
    }

    /**
     * @covers CodeCollab\CsrfToken\Generator\RandomBytes32::generate
     */
    public function testGenerateNoSufficientStrength()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('random_bytes');

        uopz_function('random_bytes', function(){
            return false;
        });

        $this->setExpectedException('CodeCollabLib\CsrfToken\Generator\InsufficientStrengthException');

        (new RandomBytes32($this->getMock('CodeCollabLib\CsrfToken\Storage\Storage')))->generate();

        uopz_restore('random_bytes');
    }
}
