<?php

namespace Tests\PHPCensor\Helper;

use PHPCensor\Helper\BuildInterpolator;
use PHPUnit\Framework\TestCase;

class BuildInterpolatorTest extends TestCase
{
    /**
     * @var BuildInterpolator
     */
    protected $testedInterpolator;

    protected function setUp()
    {
        parent::setup();
        $this->testedInterpolator = new BuildInterpolator();
    }

    public function testInterpolate_LeavesStringsUnchangedByDefault()
    {
        $string = "Hello World";
        $expectedOutput = "Hello World";

        $actualOutput = $this->testedInterpolator->interpolate($string);

        self::assertEquals($expectedOutput, $actualOutput);
    }

    public function testInterpolate_LeavesStringsUnchangedWhenBuildIsSet()
    {
        $build = $this->prophesize('PHPCensor\\Model\\Build')->reveal();

        $string         = "Hello World";
        $expectedOutput = "Hello World";

        $this->testedInterpolator->setupInterpolationVars(
            $build,
            'php-censor.local',
            '1.0.0'
        );

        $actualOutput = $this->testedInterpolator->interpolate($string);

        self::assertEquals($expectedOutput, $actualOutput);
    }
}
