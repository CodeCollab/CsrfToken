<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\CsrfToken\Generator;

use CodeCollab\CsrfToken\Generator\RandomBytes32;
use CodeCollab\CsrfToken\Generator\Generator;
use CodeCollab\CsrfToken\Storage\Storage;
use CodeCollab\CsrfToken\Generator\InsufficientStrengthException;

class RandomBytes32Test extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf(Generator::class, new RandomBytes32($this->createMock(Storage::class)));
    }

    /**
     * @covers CodeCollab\CsrfToken\Generator\RandomBytes32::generate
     */
    public function testGenerateCorrect()
    {
        $this->assertSame(32, strlen((new RandomBytes32($this->createMock(Storage::class)))->generate()));
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

        $this->assertSame('generatedtoken32', (new RandomBytes32($this->createMock(Storage::class)))->generate());

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
            throw new \Exception ('Could not gather sufficient random data', 1);
        });

        $this->expectException(InsufficientStrengthException::class);
        $this->expectExceptionMessage('Could not gather sufficient random data');

        (new RandomBytes32($this->createMock(Storage::class)))->generate();

        uopz_restore('random_bytes');
    }
}
