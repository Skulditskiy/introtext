<?php

namespace IntrotextParser;

class StateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function addExpectation_test()
    {
        // prepare
        /** @var Expectation|\PHPUnit_Framework_MockObject_MockObject $sampleExpectation */
        $sampleExpectation = $this->getMockBuilder(Expectation::class)
            ->disableOriginalConstructor()
            ->getMock();
        $classUnderTest = new State();

        // test
        $classUnderTest->addExpectation($sampleExpectation);
        $result = $classUnderTest->getExpectations();

        // verify
        $this->assertEquals([$sampleExpectation], $result);
    }

    /**
     * @test
     */
    public function getCallback_test()
    {
        // prepare
        $expectedResult = uniqid('someExpectedResult');

        /** @var Expectation|\PHPUnit_Framework_MockObject_MockObject $sampleFalseExpectation */
        $sampleFalseExpectation = $this->getMockBuilder(Expectation::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sampleFalseExpectation->expects($this->once())
            ->method('checkExpectation')
            ->willReturn(false);

        /** @var Expectation|\PHPUnit_Framework_MockObject_MockObject $sampleTrueExpectation */
        $sampleTrueExpectation = $this->getMockBuilder(Expectation::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sampleTrueExpectation->expects($this->once())
            ->method('checkExpectation')
            ->willReturn(true);
        $sampleTrueExpectation->expects($this->once())
            ->method('getActionCallback')
            ->willReturn($expectedResult);

        $classUnderTest = new State();

        // test
        $classUnderTest->addExpectation($sampleFalseExpectation);
        $classUnderTest->addExpectation($sampleTrueExpectation);
        $result = $classUnderTest->getCallback('anySymbol');

        // verify
        $this->assertEquals($expectedResult, $result);
    }


}