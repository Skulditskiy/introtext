<?php

namespace IntrotextParser;

class ExpectationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function checkExpectation_true_test()
    {
        // prepare
        $expectedResult = true;
        /** @var Expectation|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(Expectation::class)
            ->setMethods(['justToAvoidConstructor'])
            ->disableOriginalConstructor()
            ->getMock();

        // test
        $classUnderTest->setExpectedSymbol('/x/');
        $result = $classUnderTest->checkExpectation('x');

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function checkExpectation_false_test()
    {
        // prepare
        $expectedResult = false;
        /** @var Expectation|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(Expectation::class)
            ->setMethods(['justToAvoidConstructor'])
            ->disableOriginalConstructor()
            ->getMock();

        // test
        $classUnderTest->setExpectedSymbol('/y/');
        $result = $classUnderTest->checkExpectation('x');

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function getExpectedSymbol_test()
    {
        // prepare
        $expectedResult = uniqid('someValue');
        /** @var Expectation|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(Expectation::class)
            ->setMethods(['justToAvoidConstructor'])
            ->disableOriginalConstructor()
            ->getMock();

        // test
        $classUnderTest->setExpectedSymbol($expectedResult);
        $result = $classUnderTest->getExpectedSymbol();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function getActionCallback_test()
    {
        // prepare
        $expectedResult = function () {
            return 'something';
        };
        /** @var Expectation|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(Expectation::class)
            ->setMethods(['justToAvoidConstructor'])
            ->disableOriginalConstructor()
            ->getMock();

        // test
        $classUnderTest->setActionCallback($expectedResult);
        $result = $classUnderTest->getActionCallback();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function constructor_test()
    {
        // prepare
        $expectedSymbol = 'someThing';
        $expectedCallback = function () {
            return 'something';
        };
        $expectedResult = [$expectedSymbol, $expectedCallback];
        $classUnderTest = new Expectation($expectedSymbol, $expectedCallback);

        // test
        $result = [
            $classUnderTest->getExpectedSymbol(),
            $classUnderTest->getActionCallback()
        ];

        // verify
        $this->assertEquals($expectedResult, $result);
    }

}