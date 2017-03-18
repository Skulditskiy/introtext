<?php

namespace IntrotextParser;

class IntrotextParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getState_test()
    {
        // prepare
        $classUnderTest = new IntrotextParser();
        /** @var State|\PHPUnit_Framework_MockObject_MockObject $mockState */
        $mockState = $this->getMockBuilder(State::class)
            ->disableOriginalConstructor()
            ->getMock();

        // test
        $classUnderTest->setState($mockState);
        $result = $classUnderTest->getState();

        // verify
        $this->assertEquals($mockState, $result);
    }

    /**
     * Covers nothing, but output method is just example of producing input
     *
     * @test
     */
    public function output_test()
    {
        // prepare
        $classUnderTest = new IntrotextParser();

        // test
        $classUnderTest->output('someThing');
    }

}
