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

    /** @var string Class of element */
    public string $class = '';

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

    public function __toString()
    {
        return (string)$this->render();
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
        $render = ($this->render ?? $this->render());
        if($render instanceof Html)
        {
            return $render->startTag();
        }
        return null;
    }

    public function startTag(): ?string
    {
        return $this->renderStartTag();
    }

    /**
     * Render end tag
     * @return string|null
     */
    public function renderEndTag(): ?string
    {
        $render = ($this->render ?? $this->render());
        if($render instanceof Html)
        {
            return $render->endTag();
        }
        return null;
    }

    public function endTag(): ?string
    {
        return $this->renderEndTag();
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
     * Sets attributes array (replace $this->attributes)
     * @param array $attributes
     * @return BaseElement
     */
    public function setAttributes(array $attributes): BaseElement
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Sets one attribute
     * @param string $attribute
     * @param string $value
     * @return $this
     */
    public function setAttribute(string $attribute, string $value): BaseElement
    {
        $this->attributes[$attribute] = $value;
        return $this;
    }

    /**
     * Add attributes (current values will be overwritten)
     * @param array $attributes
     * @return $this
     */
    public function addAttributes(array $attributes): BaseElement
    {
        foreach($attributes as $key => $value)
            $this->attributes[$key] = $value;
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
     * @param string $class
     * @return BaseElement
     */
    public function setClass(string $class): BaseElement
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Add class (current class will not be overwritten)
     * @param string $class
     * @return $this
     */
    public function addClass(string $class): BaseElement
    {
        $this->class = sprintf('%s%s%s', $this->class, empty($this->class) ? '' : ' ', $class);
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
     * Sets one data-attribute
     * @param string $attribute
     * @param string $value
     * @return $this
     */
    public function setDataAttribute(string $attribute, string $value): BaseElement
    {
        $this->dataAttributes[$attribute] = $value;
        return $this;
    }

    /**
     * Add data attributes ($this->dataAttributes will not be overwritten)
     * @param array $dataAttributes
     * @return $this
     */
    public function addDataAttributes(array $dataAttributes): BaseElement
    {
        foreach($dataAttributes as $key => $value)
            $this->dataAttributes[$key] = $value;
        return $this;
    }

    /**
     * Set element as hidden (render will return null)
     * @param bool $hidden
     * @return $this
     */
    public function setHidden(bool $hidden=true): BaseElement
    {
        $this->hideElement = $hidden;
        return $this;
    }
}