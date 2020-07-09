<?php
declare(strict_types=1);

namespace e2221\HtmElement;

use Nette\Utils\Html;

class HrefElement extends BaseElement
{
    protected ?string $elName = 'a';

    /** @var string|null  */
    protected ?string $link = '#';

    /** @var bool set target of link as _blank */
    protected bool $targetBlank = false;

    public function __construct(?string $elName = null, ?array $attributes = null, ?string $textContent = null)
    {
        parent::__construct($this->elName, $attributes, $textContent);
    }

    public function render(): ?Html
    {
        if(is_null($this->element->href))
            $this->element->href($this->link);
        return parent::render();
    }

    /** Get static class
     * @param string|null $elName
     * @param array $attributes
     * @param string|null $textContent
     * @return BaseElement
     */
    public static function getStatic(?string $elName=null, array $attributes=[], ?string $textContent=null)
    {
        return new self($elName, $attributes, $textContent);
    }

    /**
     * Sets link attribute to element
     * @param string $href
     * @param array|null $query
     * @return HrefElement
     */
    public function setHref(string $href, ?array $query=null): HrefElement
    {
        $this->getElement()->href($href, $query);
        $this->link = $this->getElement()->href;
        return $this;
    }

    /**
     * Set target blank
     * @param bool $targetBlank
     * @return HrefElement
     */
    public function setTargetBlank(bool $targetBlank=true): HrefElement
    {
        $this->targetBlank = $targetBlank;
        if($targetBlank)
            $this->attributes['target'] = '_blank';
        return $this;
    }

    /**
     * Set confirmation
     * @param string $text  text of confirmation
     * @param string $attribute attribute (onclick, onmousedown, ...)
     * @return $this
     */
    public function setConfirmation(string $text, string $attribute='onclick'): HrefElement
    {
        $this->attributes[$attribute] = new Confirmation($text);
        return $this;
    }

}