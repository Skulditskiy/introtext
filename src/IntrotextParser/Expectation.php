<?php

namespace IntrotextParser;

/**
 * Class Expectation
 * @package IntrotextParser
 */
class Expectation
{
    /** @var string */
    private $expectedSymbol = '/./';

    /** @var callable|null */
    private $actionCallback;

    /**
     * Expectation constructor.
     * @param string $expectedSymbol
     * @param \Closure $callback
     */
    public function __construct($expectedSymbol, $callback)
    {
        $this->setExpectedSymbol($expectedSymbol);
        $this->setActionCallback($callback);
    }

    /**
     * @param $symbol
     * @return callable|null
     */
    public function checkExpectation($symbol)
    {
        return preg_match($this->expectedSymbol, $symbol);
    }

    /**
     * @return callable|null
     */
    public function getActionCallback()
    {
        return $this->actionCallback;
    }

    /**
     * @param callable|null $actionCallback
     */
    public function setActionCallback($actionCallback)
    {
        $this->actionCallback = $actionCallback;
    }

    /**
     * @return string
     */
    public function getExpectedSymbol()
    {
        return $this->expectedSymbol;
    }

    /**
     * @param string $expectedSymbol
     */
    public function setExpectedSymbol($expectedSymbol)
    {
        $this->expectedSymbol = $expectedSymbol;
    }

}
