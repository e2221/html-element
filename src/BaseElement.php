<?php
declare(strict_types=1);

namespace e2221\HtmElement;

use Nette\Utils\Html;

class BaseElement
{
    public ?Html $element;

    /** @var string|null Element Name (div, a, input) */
    protected ?string $elName = null;

    /** @var array Element attributes ['id'=>'myId', class=>'myClass'] */
    public array $attributes = [];

    /** @var array Element data attributes */
    public array $dataAttributes = [];

    /** @var string|null Plain-text content of element */
    public ?string $textContent = null;

    /** @var string|null Class of element */
    public ?string $class = null;

    /** @var string|null Title attribute */
    public ?string $title = null;

    /** @var bool If element is hidden - renderer will render null */
    public bool $hideElement = false;

    /** @var null|Html|string */
    protected $render=null;


    public function __construct(?string $elName=null, ?array $attributes=null, ?string $textContent=null)
    {
        $this->attributes = $attributes ?? $this->attributes;
        $this->textContent = $textContent ?? $this->textContent;
        $this->elName = $elName ?? $this->elName;
        $this->element = Html::el($this->elName);
    }

    /**
     * Render html element
     * @return Html|null
     */
    public function render(): ?Html
    {
        if($this->hideElement === true)
            return null;

        if(!is_null($this->elName))
            $this->element->setName($this->elName);

        //set attribute class
        $class = $this->getElementClass();
        if(!is_null($class) && !empty($class))
            $this->attributes['class'] = $class;

        if(!is_null($this->title))
            $this->attributes['title'] = $this->title;

        //attributes
        foreach ($this->attributes as $attribute => $value) {
            $this->element->setAttribute($attribute, $value);
        }
        //data-attributes
        foreach ($this->dataAttributes as $dataAttribute => $value) {
            $this->element->data($dataAttribute, $value);
        }
        //text-content
        if(!is_null($this->textContent))
            $this->element->setText($this->textContent);

        return $this->render = $this->element;
    }

    /**
     * Render start tag
     * @return string|null
     */
    public function renderStartTag(): ?string
    {
        $render = ($a ?? $this->render());
        if($render instanceof Html)
        {
            return $render->startTag();
        }
        return null;
    }

    /**
     * Render end tag
     * @return string|null
     */
    public function renderEndTag(): ?string
    {
        $render = ($a ?? $this->render());
        if($render instanceof Html)
        {
            return $render->endTag();
        }
        return null;
    }

    /**
     * Render and echo
     */
    public function renderPrint(): void
    {
        echo $this->render();
    }

    /**
     * Render and echo Start tag
     */
    public function renderPrintStartTag(): void
    {
        echo $this->renderStartTag();
    }

    /**
     * Render and echo End tag
     */
    public function renderPrintEndTag(): void
    {
        echo $this->renderEndTag();
    }

    /** Get this as static class
     * @param string|null $elName
     * @param array $attributes
     * @param string|null $textContent
     * @return BaseElement
     */
    public static function getStatic(?string $elName=null, array $attributes=[], ?string $textContent=null)
    {
        return new static($elName, $attributes, $textContent);
    }

    /** Add Html to the element
     * @param string|Html $html
     * @return BaseElement
     */
    public function addHtml($html): BaseElement
    {
        $this->element->addHtml($html);
        return $this;
    }

    /**
     * Adds Element to this element
     * @param BaseElement $element
     * @return $this
     */
    public function addElement(BaseElement $element): BaseElement
    {
        $this->element->addHtml($element->render());
        return $this;
    }


    /**
     * Gets instance of Nette HTML element
     * @return Html
     */
    public function getElement(): Html
    {
        return $this->element;
    }

    /**
     * Gets element class (connect $this->class with $this->attributes['class']
     * @return string|null
     */
    public function getElementClass(): ?string
    {
        $class = $this->class;
        if(is_array($this->attributes) && array_key_exists('class', $this->attributes))
        {
            $class .= ' ' . $this->attributes['class'];
        }
        return (is_null($class) ? $class : ltrim($class));
    }


    /**
     * Directly set Html element
     * @param Html|null $element
     * @return BaseElement
     */
    public function setElement(?Html $element): BaseElement
    {
        $this->element = $element;
        return $this;
    }

    /**
     * Sets element name (<a>, <div>, <input>, ...)
     * @param string|null $elName
     * @return BaseElement
     */
    public function setElName(?string $elName): BaseElement
    {
        $this->elName = $elName;
        return $this;
    }

    /**
     * Sets attributes (onclick="function(){}")
     * @param array $attributes
     * @return BaseElement
     */
    public function setAttributes(array $attributes): BaseElement
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Sets text content
     * @param string|null $textContent
     * @return BaseElement
     */
    public function setTextContent(?string $textContent): BaseElement
    {
        $this->textContent = $textContent;
        return $this;
    }

    /**
     * Sets class to the element
     * @param string|null $class
     * @return BaseElement
     */
    public function setClass(?string $class): BaseElement
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Sets title attribute of element
     * @param string|null $title
     * @return BaseElement
     */
    public function setTitle(?string $title): BaseElement
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Sets data attributes (data-ajax=false)
     * @param array $dataAttributes
     * @return BaseElement
     */
    public function setDataAttributes(array $dataAttributes): BaseElement
    {
        $this->dataAttributes = $dataAttributes;
        return $this;
    }

    /**
     * Set element as hidden
     * @param bool $hidden
     * @return $this
     */
    public function setHidden(bool $hidden=true): BaseElement
    {
        $this->hideElement = $hidden;
        return $this;
    }

}