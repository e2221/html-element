<?php

require __DIR__ . '../../../../autoload.php';
foreach (glob(__DIR__ . "/../src/*.php") as $filename)
{
    include $filename;
}

//hidden element
\e2221\HtmElement\BaseElement::getStatic('div', ['class'=>'bg-primary'])    //el name = html element name, parameters => array of attributes
->addElement(\e2221\HtmElement\BaseElement::getStatic('p')
    ->addElement(\e2221\HtmElement\HrefElement::getStatic() // will add html element to the html element
    ->setTextContent('link')    // will set text content
    ->setHref('https://google.com')  // will set href link
    ->setConfirmation('aaa')         // will set javascript confirmation
    ->setClass('             myLinkClass') // will set class of element
    //->setHidden()                         // will hide this element
    )
    ->setDataAttributes(['ajax' => 'false'])   // will set data-ajax="false" to attribute
    ->setTitle('my title')              // will set attribute title
    ->setAttributes(['title' => 'my title', 'anyattribute' => 'anyvalue']) // will set also title or any html attribute
)
    ->renderPrint();

echo '<br>';


$test = new \e2221\HtmElement\BaseElement('a');
echo $test->setElName('a')
    ->setAttributes(['href' => 'seznam.cz'])
    ->setTextContent('text')
    ->render();

echo '<br>';

// href element extends BaseElement, but it´s prepared with href html attributes
$a = new \e2221\HtmElement\HrefElement();
$a->setHref('https://www.google.com', ['q' => 'searchtext'])
    ->setTextContent('link')
    ->setTargetBlank()
    ->renderPrint();

//you can simply get html Nette element
$a->getElement(); //returns \Nette\Utils\Html instance

echo '<br>';

//you can also print only start|end tag
echo $a->renderStartTag() . 'my content of element' . $a->renderEndTag();

echo '<br>';

//render + echo
$a->renderPrintStartTag();
echo 'my another content';
$a->renderPrintEndTag();



echo '<br>';


//href with javascript confirmation
\e2221\HtmElement\HrefElement::getStatic()
    ->setTextContent('newLink')
    ->setHref('https://www.google.com', ['q' => 'filsearch with text'])
    ->setTargetBlank()
    ->setConfirmation('Are you confirm?')
    ->renderPrint();