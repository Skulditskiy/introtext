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

    /**
     * Output closing necessary closing tags based on count of saved opened and closed tags during parsing
     */
    public function completeTags()
    {
        $result = '';
        for ($i = count($this->openingTags)-1; $i >= 0; $i--) {
            $openedTag = $this->openingTags[$i];
            if ((count($this->closingTags)) && ($openedTag == end($this->closingTags))) {
                array_pop($this->closingTags);
            } else {
                $result .= '</' . $openedTag . '>';
            }
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function isFinished()
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
        $this->buffer = str_replace('[b]', '<b>', $this->buffer, $count);
        if ($count) {
            $this->addOpeningTag('b');
        }

        $this->buffer = str_replace('[/b]', '</b>', $this->buffer, $count);
        if ($count) {
            $this->addClosingTag('b');
        }

        $this->buffer = str_replace('[i]', '<i>', $this->buffer, $count);
        if ($count) {
            $this->addOpeningTag('i');
        }

        $this->buffer = str_replace('[/i]', '</i>', $this->buffer, $count);
        if ($count) {
            $this->addClosingTag('i');
        }

        $this->buffer = preg_replace('/\[url=(.*)\]/','<a href="$1">', $this->buffer, -1, $count);
        if ($count) {
            $this->addOpeningTag('a');
        }

        $this->buffer = str_replace('[/url]', '</a>', $this->buffer, $count);
        if ($count) {
            $this->addClosingTag('a');
        }

        $this->output($this->buffer);
        $this->buffer = '';
    }

}
