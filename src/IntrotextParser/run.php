<?php

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "vendor".DIRECTORY_SEPARATOR."autoload.php";

use IntrotextParser\IntrotextParser;
use IntrotextParser\State;
use IntrotextParser\Expectation;

$introtextParser = new IntrotextParser();

/**
 * defining all possible states of parser
 */
$stateNormalProxy = new State();
$stateWaitingCinCut = new State();
$stateWaitingUinCut = new State();
$stateWaitingTinCut = new State();
$stateWaitingClosingBracketInCut = new State();
$stateAfterOpeningBracket = new State();
$stateWaitingRinUrlOpening = new State();
$stateWaitingLinUrlOpening = new State();
$stateWaitingEqualInUrlOpening = new State();
$stateWaitingClosingBracketInUrl = new State();
$stateWaitingClosingBracket = new State();
$stateWaitingClosingTag = new State();
$stateWaitingRinUrlClosing = new State();
$stateWaitingLinUrlClosing = new State();
$stateWaitingClosingBracketInClosingTag = new State();


$normalProxyExpectation = new Expectation(
    '/./',
    function ($parser) use ($stateNormalProxy) {
        /** @var IntrotextParser $parser */
        $parser->flushBuffer();
        $parser->setState($stateNormalProxy);
    }
);

$stateNormalProxy->addExpectation(new Expectation(
    '/</',
    function ($parser) use ($stateWaitingCinCut) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingCinCut);
    }
));
$stateNormalProxy->addExpectation(new Expectation(
    '/\[/',
    function ($parser) use ($stateAfterOpeningBracket) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateAfterOpeningBracket);
    }
));
$stateNormalProxy->addExpectation($normalProxyExpectation);


$stateWaitingCinCut->addExpectation(new Expectation(
    '/c/',
    function ($parser) use ($stateWaitingUinCut) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingUinCut);
    }
));
$stateWaitingCinCut->addExpectation($normalProxyExpectation);


$stateWaitingUinCut->addExpectation(new Expectation(
    '/u/',
    function ($parser) use ($stateWaitingTinCut) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingTinCut);
    }
));
$stateWaitingUinCut->addExpectation($normalProxyExpectation);


$stateWaitingTinCut->addExpectation(new Expectation(
    '/t/',
    function ($parser) use ($stateWaitingClosingBracketInCut) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingBracketInCut);
    }
));
$stateWaitingTinCut->addExpectation($normalProxyExpectation);


$stateWaitingClosingBracketInCut->addExpectation(new Expectation(
    '/>/',
    function ($parser) {
        /** @var IntrotextParser $parser */
        $parser->buffer = '';
        $parser->flushBuffer();
        $parser->setIsFinished(true);
    }
));
$stateWaitingClosingBracketInCut->addExpectation($normalProxyExpectation);


$stateAfterOpeningBracket->addExpectation(new Expectation(
    '/b/',
    function ($parser) use ($stateWaitingClosingBracket) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingBracket);
    }
));
$stateAfterOpeningBracket->addExpectation(new Expectation(
    '/i/',
    function ($parser) use ($stateWaitingClosingBracket) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingBracket);
    }
));
$stateAfterOpeningBracket->addExpectation(new Expectation(
    '/u/',
    function ($parser) use ($stateWaitingRinUrlOpening) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingRinUrlOpening);
    }
));
$stateAfterOpeningBracket->addExpectation(new Expectation(
    '/\//',
    function ($parser) use ($stateWaitingClosingTag) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingTag);
    }
));
$stateAfterOpeningBracket->addExpectation($normalProxyExpectation);


$stateWaitingRinUrlOpening->addExpectation(new Expectation(
    '/r/',
    function ($parser) use ($stateWaitingLinUrlOpening) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingLinUrlOpening);
    }
));
$stateWaitingRinUrlOpening->addExpectation($normalProxyExpectation);

$stateWaitingLinUrlOpening->addExpectation(new Expectation(
    '/l/',
    function ($parser) use ($stateWaitingEqualInUrlOpening) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingEqualInUrlOpening);
    }
));
$stateWaitingLinUrlOpening->addExpectation($normalProxyExpectation);


$stateWaitingEqualInUrlOpening->addExpectation(new Expectation(
    '/=/',
    function ($parser) use ($stateWaitingClosingBracketInUrl) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingBracketInUrl);
    }
));
$stateWaitingEqualInUrlOpening->addExpectation($normalProxyExpectation);


$stateWaitingClosingBracketInUrl->addExpectation(new Expectation(
    '/\]/',
    function ($parser) use ($stateNormalProxy) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateNormalProxy);
    }
));
$stateWaitingClosingBracketInUrl->addExpectation(new Expectation(
    '/./',
    function ($parser) use ($stateWaitingClosingBracketInUrl) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingBracketInUrl);
    }
));


$stateWaitingClosingBracket->addExpectation(new Expectation(
    '/\]/',
    function ($parser) use ($stateNormalProxy) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateNormalProxy);
    }
));
$stateWaitingClosingBracket->addExpectation($normalProxyExpectation);


$stateWaitingClosingTag->addExpectation(new Expectation(
    '/b/',
    function ($parser) use ($stateWaitingClosingBracketInClosingTag) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingBracketInClosingTag);
    }
));
$stateWaitingClosingTag->addExpectation(new Expectation(
    '/i/',
    function ($parser) use ($stateWaitingClosingBracketInClosingTag) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingBracketInClosingTag);
    }
));
$stateWaitingClosingTag->addExpectation(new Expectation(
    '/u/',
    function ($parser) use ($stateWaitingRinUrlClosing) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingRinUrlClosing);
    }
));
$stateWaitingClosingBracket->addExpectation($normalProxyExpectation);


$stateWaitingRinUrlClosing->addExpectation(new Expectation(
    '/r/',
    function ($parser) use ($stateWaitingLinUrlClosing) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingLinUrlClosing);
    }
));
$stateWaitingRinUrlClosing->addExpectation($normalProxyExpectation);

$stateWaitingLinUrlClosing->addExpectation(new Expectation(
    '/l/',
    function ($parser) use ($stateWaitingClosingBracketInClosingTag) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateWaitingClosingBracketInClosingTag);
    }
));
$stateWaitingLinUrlClosing->addExpectation($normalProxyExpectation);


$stateWaitingClosingBracketInClosingTag->addExpectation(new Expectation(
    '/\]/',
    function ($parser) use ($stateNormalProxy) {
        /** @var IntrotextParser $parser */
        $parser->setState($stateNormalProxy);
    }
));
$stateWaitingClosingBracketInClosingTag->addExpectation($normalProxyExpectation);




/**
 * run the parser
 */
$introtextParser->setState($stateNormalProxy);

$text = 'bal[b]f[b][url=http://ya.ru]d[/url][/b][i]sd';
$i = 0;

while (!$introtextParser->isIsFinished()) {
    $introtextParser->proceedCharacter($text[$i]);
    $i++;
    if ($i >= strlen($text)) {
        break;
    }
}
$introtextParser->completeTags();