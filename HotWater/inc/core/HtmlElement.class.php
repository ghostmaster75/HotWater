<?php
namespace core;

use Exception;

class HtmlElement
{

    private $tag;

    private $attributes = array();

    private $content;

    private const HTML_OPEN = "<%s %s%s>%s";

    private const HTML_CLOSE = "</%s>";

    private const SLASH = "/";

    public function __construct(string $htmlTag)
    {
        if (HtmlTags::isValidValue(strtolower($htmlTag))) {
            $this->tag = $htmlTag;
        } else {
            throw new Exception($htmlTag . " is not a valid html tag");
        }
    }

    public function removeAttribute(string $attributeName)
    {
        if (isset($this->attributes[$attributeName])) {
            unset($this->attributes[$attributeName]);
        }
    }

    public function setAttribute(string $attributeName, $attributeValue)
    {
        if (isset($this->attributes[$attributeName])) {
            unset($this->attributes[$attributeName]);
        }
        $this->attributes[$attributeName] = $attributeValue;
    }

    public function getAttribute(string $attributeName)
    {
        if (! isset($this->attributes[$attributeName])) {
            return NULL;
        }
        
        return $this->attributes[$attributeName];
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getHtmlTag()
    {
        $html = "";
        $attributes = "";
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $attributes .= $attributeName . "='" . $attributeValue . "' ";
        }
        if (HtmlNoClosingTags::isValidValue(strtolower($this->tag))) {
            $html = sprintf(self::HTML_OPEN, $this->tag, $attributes, self::SLASH, $this->content);
        } else {
            $html = sprintf(self::HTML_OPEN, $this->tag, $attributes, "", $this->content) . sprintf(self::HTML_CLOSE, $this->tag);
        }
        return $html;
    }
}
?>