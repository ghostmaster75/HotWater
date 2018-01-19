<?php
namespace core;

use Exception;

/**
 *
 * @author Pierluigi Natale
 *        
 *         class BasePage
 *        
 */
class BasePage
{

    private $templateName;

    private $template;

    private $title;

    private $css = array();

    private $script = array();

    private $content = array();

    private const LINKCSS = "<link rel='stylesheet' href='{css}'>" . PHP_EOL;

    private const LINKSCRIPT = "<script src='{script}'></script>" . PHP_EOL;

    /**
     *
     * @param string $templateName
     *            Name of base page template. Default is 'basepage'.
     *            
     */
    public function __construct(string $templateName = 'basepage')
    {
        $this->templateName = $templateName;
        self::getTemplateFile();
        self::checkTemplate();
    }

    private function getTemplateFile()
    {
        if (! $this->template = file_get_contents("templates/" . $this->templateName . ".ctp")) {
            throw new \Exception("Error on opening 'templates/" . $this->templateName . ".ctp'");
        }
    }

    private function checkTemplate()
    {
        $count = preg_match_all("({content})", $this->template);
        if ($count == FALSE) {
            throw new \Exception("Template 'templates/" . $this->templateName . ".ctp' error. No {content} tag found");
        }
        
        if ($count > 1) {
            throw new \Exception("Template 'templates/" . $this->templateName . ".ctp' error. Found $count {content} tag. Expected only 1");
        }
    }

    public function setPageTitle(string $title)
    {
        $this->title = $title;
    }

    public function getPageTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param string $cssUrl
     *            css file with path. Can be absolute or relative.
     * @throws Exception $cssUrl cannot be null
     * @return void
     */
    public function addCss(string $cssUrl)
    {
        if (isset($cssUrl)) {
            $this->css[] = $cssUrl;
        } else {
            throw new Exception("css URL cannot be null");
        }
    }

    /**
     *
     * @param array $cssList
     *            Array of css file path.
     * @return void
     */
    public function addCssList(array $cssList)
    {
        $this->css = array_merge($this->css, $cssList);
    }

    /**
     *
     * @param string $cssUrl
     *            css file path to remove
     * @throws Exception
     */
    public function removeCss(string $cssUrl)
    {
        if (! isset($cssUrl)) {
            throw new Exception("css URL cannot be null");
        }
        
        if (($i = array_search($cssUrl, $this->css)) !== FALSE) {
            unset($this->css[$i]);
        }
    }

    /**
     *
     * @param string $scriptUrl
     * @throws Exception
     */
    public function addScript(string $scriptUrl)
    {
        if (isset($scriptUrl)) {
            $this->script[] = $scriptUrl;
        } else {
            throw new Exception("script URL cannot be null");
        }
    }

    /**
     *
     * @param array $scriptList
     */
    public function addScriptList(array $scriptList)
    {
        $this->script = array_merge($this->script, $scriptList);
    }

    /**
     *
     * @param string $scriptUrl
     * @throws Exception
     */
    public function removeScript(string $scriptUrl)
    {
        if (! isset($scriptUrl)) {
            throw new Exception("script URL cannot be null");
        }
        
        if (($i = array_search($scriptUrl, $this->script)) !== FALSE) {
            unset($this->script[$i]);
        }
    }

    /**
     *
     * @param string $contentName
     * @param Template $contentValue
     * @throws Exception
     */
    public function addContent(string $contentName, $contentValue)
    {
        if (get_class($contentValue) != Template::class && get_class($contentValue) != HtmlElement::class) {
            throw new Exception("ContentValue must be a Tempate object or HtmlElement object this content is " . get_class($contentValue));
        }
        
        if (! isset($contentName)) {
            throw new Exception("Content Name cannot be null");
        }
        $this->content[$contentName] = $contentValue;
        if (get_class($contentValue) == Template::class) {
            $this->addCssList($contentValue->getCss());
            $this->addScriptList($contentValue->getScript());
        }
    }

    /**
     *
     * @param string $contentName
     * @throws Exception
     */
    public function removeContent(string $contentName)
    {
        if (! isset($contentName)) {
            throw new Exception("Content Name cannot be null");
        }
        
        if (array_key_exists($contentName, $this->content)) {
            unset($this->content[$contentName]);
        }
    }

    /**
     */
    private function buildPage()
    {
        $css = "";
        $script = "";
        $content = "";
        
        foreach ($this->css as $cssUrl) {
            if (is_array($cssUrl)) {
                foreach ($cssUrl as $cssContentName =>  $subCssurl) {
                    $css .= preg_replace("({css})", $subCssurl, self::LINKCSS);
                }
            } else {
                $css .= preg_replace("({css})", $cssUrl, self::LINKCSS);
            }
        }
        foreach ($this->script as $scriptUrl) {
            if (is_array($scriptUrl)) {
                foreach ($scriptUrl as $scriptContentName => $subScripUrl) {
                    $script .= preg_replace("({script})", $subScripUrl, self::LINKSCRIPT);
                }
            } else {
                $script .= preg_replace("({script})", $scriptUrl, self::LINKSCRIPT);
            }
        }
        
        foreach ($this->content as $contentName => $contentValue) {
            if (get_class($contentValue) == Template::class) {
                $content .= PHP_EOL . "<!-- " . $contentName . " -->" . $contentValue->getTemplate();
            } else {
                $content .= PHP_EOL . "<!-- " . $contentName . " -->" . $contentValue->getHtmlTag();
            }
        }
        
        $this->template = preg_replace("({pagetitle})", $this->getPageTitle(), $this->template);
        $this->template = preg_replace("({css})", $css, $this->template);
        $this->template = preg_replace("({script})", $script, $this->template);
        $this->template = preg_replace("({content})", $content, $this->template);
    }

    /**
     *
     * @return string template
     */
    public function getPage()
    {
        self::buildPage();
        return $this->template;
    }

    public function showPage()
    {
        self::buildPage();
        echo $this->template;
    }
}

?>