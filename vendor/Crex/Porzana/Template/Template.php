<?php

namespace Crex\Porzana\Template;

use Crex\CrexObject;

class Template extends CrexObject {
    
    private $templateString;
    private $mainTemplate;
    private $templates = array();
    
    
    public function __construct(\crex\Container\Container $container, array $parameters = NULL) {
        parent::__construct($container, $parameters);
    }
    
    public function returnParsedTemplate() {
        $this->parse();
        return $this->templateString;
    }
        
    public function setTemplateString($value) {
        $this->templateString = $value;
        return $this;
    }
    
    public function setMainTemplate($value) {
        $this->mainTemplate = $value;
        return $this;
    }
    
    public function setTemplates($value = array()) {
        $this->templates = $value;
        return $this;
    }
        
    private function parse() {
        $this->loadMainTemplate();
        $this->replaceTemplateShortcut();        
        preg_match_all('~\{[^{}]*\}~', $this->templateString, $matches);
        $keywords = array();
        foreach($matches[0] as $key => $keyword) {
            $keywords[$keyword] = str_replace('}', '', str_replace('{' , '', $matches[0][$key]));
        }
        foreach($keywords as $key => $word) {
            $replacedString = $this->container->getService('Porzana')->returnReplacedString($word);
            $this->templateString = str_replace($key, $replacedString, $this->templateString);
        }
    }
    
    private function replaceTemplateShortcut() {
        $keywords = array();
        $matches = array();
        preg_match_all('/\{\_[^{}]*\}/', $this->templateString, $matches);
        while(count($matches[0]) > 0) {
            foreach($matches[0] as $key => $keyword) {
                $keywords[$keyword] = substr(str_replace('}', '', str_replace('{', '', $matches[0][$key])), 1);
            }
            foreach($keywords as $key => $word) {
                if(!isset($this->templates[$word])) {
                    throw new \crex\Porzana\Exception\TemplateException('Can not replace shortcut ' . $key . '. Template ' . $word . ' is not defined.');
                }
                if(!file_exists($this->templates[$word])) {
                    throw new \crex\Porzana\Exception\TemplateException('Can not load template ' . $this->templates[$word] . '. File does not exists.');
                }
                $this->templateString = str_replace($key, file_get_contents($this->templates[$word]), $this->templateString);
            }
            preg_match_all('/\{\_(.*)\_\}/', $this->templateString, $matches);
        }
    }
    
    private function loadMainTemplate() {
        if(empty($this->mainTemplate)) {
            throw new \crex\Porzana\Exception\TemplateException('Main template is not defined.');
        }
        if(!file_exists($this->mainTemplate)) {
            throw new \crex\Porzana\Exception\TemplateException('Can not load template ' . $this->mainTemplate . '. File does not exists.');
        }
        $this->templateString = file_get_contents($this->mainTemplate);       
    }
}
