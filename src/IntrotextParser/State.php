<?php

namespace IntrotextParser;

/**
 * Class State
 * @package IntrotextParser
 */
class State
{
    /** @var  Expectation[] */
    private $expectations;

    /**
     * @param Expectation $expectation
     */
    public function addExpectation(Expectation $expectation)
    {
        $this->expectations[] = $expectation;
    }

    /**
     * @param $symbol
     * @return \Closure|null
     */
    public function getCallback($symbol)
    {
        $result = null;
        foreach ($this->expectations as $expectation) {
            if ($expectation->checkExpectation($symbol)) {
                $result = $expectation->getActionCallback();
                break;
            }
        }
        return $result;
    }

}
