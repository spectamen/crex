<?php

namespace crex\Controller;

use crex\Controller\Controller;
use crex\CrexObject;

abstract class Controller extends CrexObject {
    
    private $template;
    private $parameters = array();
    
    public function __construct($container, Controller $parentController = NULL) {
	$this->container = $container;
        if(isset($parentController)) {
            $this->parentController = $parentController;
        }
        $this->setDefaultParameters();
        return $this;
    }
    
    abstract function life();
    
    public function birth() {
        
    }
    
    public function death() {
        
    }

    public function redirect($url) {
        header("Location: " . ADDRESS . $url . "/");
        header("Connection: close");
        exit;
    }
    
    public function loadTemplatePath() {
        if(isset($this->template)) {
            $templatePath = '..\www\templates\\' . LANG . '\\' . $this->template . '.phtml';
        } else {
            $templatePath = '..\www\templates\\' . LANG . 
                    strtolower(str_replace('\\\\', '\\', str_replace('Controller', '', str_replace('App', '', get_class($this))))) . 
                    '.phtml';
        }
        $templatePath = str_replace('\\\\', '\\' , $templatePath);
        return $templatePath;
    }
    
    private function setDefaultParameters() {
        $this->container->setParameter('title', DEFAULT_TITLE);
        $this->container->setParameter('description', DEFAULT_DESCRIPTION);
        $this->container->setParameter('keywords', DEFAULT_KEYWORDS);
        return $this;
    }
    
    public function getTemplate() {
        return $this->template;
    }

    public function setTemplate($template) {
        $this->template = $template;
        return $this;
    }
    
    public function setParameter($name, $value) {
        $this->parameters[$name] = $value;
        return $this;
    }
    
    public function getParameters() {
        return $this->parameters;
    }
    
    public function getParameter($name) {
        if (!array_key_exists(!$name, $this->parameters)) {
            new \crex\Exception\ArrayKeyExistsException();
        }
        return $this->parameters[$name];
    }
    
    public function registerParameters() {
        foreach($this->getParameters() as $key => $value) {
            $this->container->setParameter($key, $value);
        }
    }
    
    public function newForm($formName) {
	$form = $this->container->getFactory('FormFactory')->create($formName);
	$this->setParameter($formName, $form);
	return $this->getParameters()[$formName];
    }
    
}
