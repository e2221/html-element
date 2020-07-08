<?php

require __DIR__ . '/../vendor/autoload.php';
foreach (glob(__DIR__ . "/../src/*.php") as $filename)
{
    include $filename;
}


$test = new \e2221\HtmElement\BaseElement('a');
echo $test->setElName('a')
    ->setAttributes(['href' => 'seznam.cz'])
    ->setTextContent('text')
    ->render();


$a = new \e2221\HtmElement\HrefElement();
$a->setHref('https://www.google.com', ['q' => 'searchtext'])
    ->setTextContent('link')
    ->setTargetBlank()
    ->renderPrint();


\e2221\HtmElement\HrefElement::getStatic()
    ->setTextContent('newLink')
    ->setHref('https://www.google.com', ['q' => 'filsearch with text'])
    ->setTargetBlank()
    ->setConfirmation('Are you confirm?')
    ->renderPrint();