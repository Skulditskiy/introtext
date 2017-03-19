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

    /**
     * @test
     */
    public function isFinished_test()
    {
        // prepare
        $classUnderTest = new IntrotextParser();
        $expectedResult = (rand(0,1) == 1);

        // test
        $classUnderTest->setIsFinished($expectedResult);
        $result = $classUnderTest->isFinished();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function completeTags_test()
    {
        // prepare
        $classUnderTest = new IntrotextParser();
        $classUnderTest->addOpeningTag('x');
        $classUnderTest->addOpeningTag('y');
        $classUnderTest->addOpeningTag('z');
        $classUnderTest->addClosingTag('z');
        $expectedResult = '</y></x>';

        // test
        $result = $classUnderTest->completeTags();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function completeTags_noOpening_test()
    {
        // prepare
        $classUnderTest = new IntrotextParser();
        $classUnderTest->addClosingTag('z');
        $classUnderTest->addClosingTag('x');
        $expectedResult = '';

        // test
        $result = $classUnderTest->completeTags();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function completeTags_noClosing_test()
    {
        // prepare
        $classUnderTest = new IntrotextParser();
        $classUnderTest->addOpeningTag('z');
        $classUnderTest->addOpeningTag('x');
        $expectedResult = '</x></z>';

        // test
        $result = $classUnderTest->completeTags();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function completeTags_noTags_test()
    {
        // prepare
        $classUnderTest = new IntrotextParser();
        $expectedResult = '';

        // test
        $result = $classUnderTest->completeTags();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage something
     */
    public function proceedCharacter_test()
    {
        // prepare
        $expectedResult = 'something';
        $mockCallback = function () use ($expectedResult) {
            throw new \Exception($expectedResult);
        };
        $mockState = $this->getMockBuilder(State::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockState->expects($this->once())
            ->method('getCallback')
            ->willReturn($mockCallback);
        /** @var IntrotextParser|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(IntrotextParser::class)
            ->setMethods(['getState'])
            ->disableOriginalConstructor()
            ->getMock();
        $classUnderTest->expects($this->once())
            ->method('getState')
            ->willReturn($mockState);

        // test
        $result = $classUnderTest->proceedCharacter('a');

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function flushBuffer_openBTag_test()
    {
        // prepare
        $expectedResult = '<b>';
        /** @var IntrotextParser|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(IntrotextParser::class)
            ->setMethods(['output'])
            ->disableOriginalConstructor()
            ->getMock();
        $classUnderTest->expects($this->once())
            ->method('output')
            ->with($expectedResult)
            ->willReturn(true);
        $classUnderTest->buffer = '[b]';

        // test
        $classUnderTest->flushBuffer();

        // verify
        $this->assertEquals('', $classUnderTest->buffer);
        // verified by mock also ('output' method expected to be called with certain text)
    }

    /**
     * @test
     */
    public function flushBuffer_closeBTag_test()
    {
        // prepare
        $expectedResult = '</b>';
        /** @var IntrotextParser|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(IntrotextParser::class)
            ->setMethods(['output'])
            ->disableOriginalConstructor()
            ->getMock();
        $classUnderTest->expects($this->once())
            ->method('output')
            ->with($expectedResult)
            ->willReturn(true);
        $classUnderTest->buffer = '[/b]';

        // test
        $classUnderTest->flushBuffer();

        // verify
        $this->assertEquals('', $classUnderTest->buffer);
        // verified by mock also ('output' method expected to be called with certain text)
    }

    /**
     * @test
     */
    public function flushBuffer_openITag_test()
    {
        // prepare
        $expectedResult = '<i>';
        /** @var IntrotextParser|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(IntrotextParser::class)
            ->setMethods(['output'])
            ->disableOriginalConstructor()
            ->getMock();
        $classUnderTest->expects($this->once())
            ->method('output')
            ->with($expectedResult)
            ->willReturn(true);
        $classUnderTest->buffer = '[i]';

        // test
        $classUnderTest->flushBuffer();

        // verify
        $this->assertEquals('', $classUnderTest->buffer);
        // verified by mock also ('output' method expected to be called with certain text)
    }

    /**
     * @test
     */
    public function flushBuffer_closeITag_test()
    {
        // prepare
        $expectedResult = '</i>';
        /** @var IntrotextParser|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(IntrotextParser::class)
            ->setMethods(['output'])
            ->disableOriginalConstructor()
            ->getMock();
        $classUnderTest->expects($this->once())
            ->method('output')
            ->with($expectedResult)
            ->willReturn(true);
        $classUnderTest->buffer = '[/i]';

        // test
        $classUnderTest->flushBuffer();

        // verify
        $this->assertEquals('', $classUnderTest->buffer);
        // verified by mock also ('output' method expected to be called with certain text)
    }

    /**
     * @test
     */
    public function flushBuffer_openUrlTag_test()
    {
        // prepare
        $expectedResult = '<a href="http://example.com">';
        /** @var IntrotextParser|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(IntrotextParser::class)
            ->setMethods(['output'])
            ->disableOriginalConstructor()
            ->getMock();
        $classUnderTest->expects($this->once())
            ->method('output')
            ->with($expectedResult)
            ->willReturn(true);
        $classUnderTest->buffer = '[url=http://example.com]';

        // test
        $classUnderTest->flushBuffer();

        // verify
        $this->assertEquals('', $classUnderTest->buffer);
        // verified by mock also ('output' method expected to be called with certain text)
    }

    /**
     * @test
     */
    public function flushBuffer_closeUrlTag_test()
    {
        // prepare
        $expectedResult = '</a>';
        /** @var IntrotextParser|\PHPUnit_Framework_MockObject_MockObject $classUnderTest */
        $classUnderTest = $this->getMockBuilder(IntrotextParser::class)
            ->setMethods(['output'])
            ->disableOriginalConstructor()
            ->getMock();
        $classUnderTest->expects($this->once())
            ->method('output')
            ->with($expectedResult)
            ->willReturn(true);
        $classUnderTest->buffer = '[/url]';

        // test
        $classUnderTest->flushBuffer();

        // verify
        $this->assertEquals('', $classUnderTest->buffer);
        // verified by mock also ('output' method expected to be called with certain text)
    }

}
