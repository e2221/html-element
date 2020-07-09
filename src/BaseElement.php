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

    public ?string $title = null;


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

        return $this->element;
    }

    /**
     * Render and echo
     */
    public function renderPrint(): void
    {
        echo $this->render();
    }

    /** Get static class
     * @param string|null $elName
     * @param array $attributes
     * @param string|null $textContent
     * @return BaseElement
     */
    public static function getStatic(?string $elName=null, array $attributes=[], ?string $textContent=null)
    {
        return new static($elName, $attributes, $textContent);
    }

    /** Add Html
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
     * Gets element class
     * @return string|null
     */
    public function getElementClass(): ?string
    {
        $class = $this->class;
        if(is_array($this->attributes) && array_key_exists('class', $this->attributes))
        {
            $class .= ' ' . $this->attributes['class'];
        }
        return $class;
    }


    /**
     * @param Html|null $element
     * @return BaseElement
     */
    public function setElement(?Html $element): BaseElement
    {
        $this->element = $element;
        return $this;
    }

    /**
     * @param string|null $elName
     * @return BaseElement
     */
    public function setElName(?string $elName): BaseElement
    {
        $this->elName = $elName;
        return $this;
    }

    /**
     * @param array $attributes
     * @return BaseElement
     */
    public function setAttributes(array $attributes): BaseElement
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string|null $textContent
     * @return BaseElement
     */
    public function setTextContent(?string $textContent): BaseElement
    {
        $this->textContent = $textContent;
        return $this;
    }

    /**
     * @param string|null $class
     * @return BaseElement
     */
    public function setClass(?string $class): BaseElement
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @param string|null $title
     * @return BaseElement
     */
    public function setTitle(?string $title): BaseElement
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param array $dataAttributes
     * @return BaseElement
     */
    public function setDataAttributes(array $dataAttributes): BaseElement
    {
        $this->dataAttributes = $dataAttributes;
        return $this;
    }

}