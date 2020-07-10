<?php

require __DIR__ . '/../vendor/autoload.php';
foreach (glob(__DIR__ . "/../src/*.php") as $filename)
{
    include $filename;
}

//hidden element
\e2221\HtmElement\BaseElement::getStatic('div', ['class'=>'bg-primary'])
    ->addElement(\e2221\HtmElement\BaseElement::getStatic('p')
        ->addElement(\e2221\HtmElement\HrefElement::getStatic()
            ->setTextContent('link')
            ->setHref('https://google.com')
            ->setConfirmation('aaa')
            ->setClass('             myLinkClass')
            ->setHidden()
        )
    )
    ->renderPrint();

echo '<br>';


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