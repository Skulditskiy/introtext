<?php

namespace IntrotextParser;

/**
 * Class IntrotextParser
 * @package IntrotextParser
 */
class IntrotextParser
{
    /** @var  string */
    public $buffer;

    /** @var State|null */
    private $state;

    /** @var bool */
    private $isFinished = false;

    /** @var array  */
    private $openingTags = [];

    /** @var array  */
    private $closingTags = [];

    /**
     * @param string $tag
     */
    public function addOpeningTag($tag) {
        $this->openingTags[] = $tag;
    }

    /**
     * @param string $tag
     */
    public function addClosingTag($tag) {
        $this->closingTags[] = $tag;
    }

    /**
     * @param string $character
     */
    public function proceedCharacter($character)
    {
        $this->buffer .= $character;
        $callback = $this->getState()->getCallback($character);
        $callback($this);
    }

    public function completeTags()
    {
        echo 'tags completed';
    }

    /**
     * @return bool
     */
    public function isIsFinished()
    {
        return (bool)$this->isFinished;
    }

    /**
     * @param bool $isFinished
     */
    public function setIsFinished($isFinished)
    {
        $this->isFinished = (bool)$isFinished;
    }

    /**
     * @param $text
     */
    public function output($text)
    {
        echo $text;
    }

    /**
     * @return State|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param State|null $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Parse and output current content of the buffer
     */
    public function flushBuffer()
    {
        $this->buffer = str_replace('[b]', '<b>', $this->buffer);
        $this->buffer = str_replace('[/b]', '</b>', $this->buffer);
        $this->buffer = str_replace('[i]', '<i>', $this->buffer);
        $this->buffer = str_replace('[/i]', '</i>', $this->buffer);
        $this->buffer = preg_replace('/\[url=(.*)\]/','<a href="$1">', $this->buffer);
        $this->output($this->buffer);
        $this->buffer = '';
    }

}
