<?php

namespace core;

class Template {
    
    private $templateName;
    private $template;
    private $fields = array();
    private $css = array();
    private $script = array();
    private const PATTERNCSS = '/\<\!\-\-\s*(css)\s*:\s*([^\s]*)\s*\-\-\>/i';
    private const PATTERNSCRIPT = '/\<\!\-\-\s*(script)\s*:\s*([^\s]*)\s*\-\-\>/i';
    
    public function __construct(String $templateName) {
        $this->templateName = $templateName;
        $this->getTemplateFile();
        self::searchCss();
        self::searchScript();
    }
    
    private function searchCss()  {
        preg_match_all(self::PATTERNCSS, $this->template, $matches);
        foreach ($matches[2] as $i => $cssFile) {
            $this-> css[] = $cssFile;
            $this->template = str_replace($matches[0][$i], "", $this->template);
        }     
    }
    
    private function searchScript()  {
        preg_match_all(self::PATTERNSCRIPT, $this->template, $matches);
        foreach ($matches[2] as $i => $scriptFile) {
            $this-> script[] = $scriptFile;
            $this->template = str_replace($matches[0][$i], "", $this->template);
        }
    }
    
    private function getTemplateFile() {
        $this->template = file_get_contents("templates/" . $this->templateName . ".ctp");
    }
    
    public function setField(String $fieldName, $fieldValue) {
        if (isset($this->fields[$fieldName])) {
            unset($this->fields[$fieldName]);
        }
        $this->fields[$fieldName][] = $fieldValue;
    }
    
    private function buildTemplate() {
        foreach ($this->fields as $fieldName => $fieldValues){
            foreach ($fieldValues as $fieldValue){
                $this->template = preg_replace("({" . $fieldName ."})", $fieldValue, $this->template);
            }
        }       
    }
    
    public function getTemplate() {
        $this->buildTemplate();
        return $this->template;
    }
    
    public function getCss() {
        return $this->css;
    }
    
    public function getScript() {
        return $this->script;
    }
    
    
    public function showTemplate() {
        $this->buildTemplate();
        echo $this->template;
    }
    
    public function addElementToField(string $fieldName, $fieldElement) {
        $this->fields[$fieldName][] = $fieldElement;
    }
    
}

?>