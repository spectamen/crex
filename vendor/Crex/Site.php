<?php

namespace crex;

use crex\Container\Container;
use crex\Router\Router;

class Site {
    
    private $container;
    private $router;
    private $parameters = array();
    
    public function __construct() {
	$this->container = new Container();
        $this->container->setTemplate('frame', $this->loadFramePath());
        $this->router = new Router($this->container);
        $this->makeSite();
    }
    
    public function getParameters() {
        return $this->parameters;
    }
    
    private function makeSite() {
        $this->container->setTemplate('controllerTemplate', $this->router->loadControllerTemplatePath());
        $this->router->birth();
        $this->router->life();
        $this->parameters = $this->container->getParameters();
        
        //draw template
        $this->container->getService('Porzana')::draw($this->container->getTemplates()['frame'], $this->container->getTemplates(), $this->parameters);
        
        $this->router->death();
    }
    
    private function loadFramePath() {
        $frame = '..\www\templates\\' . LANG . '\frame.phtml';
        $frame = str_replace('\\\\', '\\', $frame);
        return $frame;
    }
}
