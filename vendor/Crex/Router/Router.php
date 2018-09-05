<?php

namespace crex\Router;

use crex\CrexObject;
use Nette\Neon\Neon;

class Router extends CrexObject {
    
    private $controller;
    
    public function __construct($container, array $parameters = NULL) {
	parent::__construct($container, $parameters);
	$this->loadController();
	return $this;
    }
    
    public function birth() {
        $this->controller->birth();
        return $this;
    }
    
    public function life() {
        $this->controller->life();
        $this->controller->registerParameters();
        return $this;
    }
    
    public function death() {
        $this->controller->death();
    }
        
    public function getParameters() {
        return $this->controller->getParameters();
    }
    
    public function loadControllerTemplatePath() {
        return $this->controller->loadTemplatePath();
    }
    
    private function loadController() {
	$routes = Neon::decode(file_get_contents('../app/routes.neon'));
        if(isset($this->container->getParameters()[0])) {
	    $controller = $this->container->getParameters()[0];
	} else {
	    $controller = 'default';
	}	
        if(isset($routes[$controller])) {
            $controllerPath = $routes[$controller];
	} else {
            if(file_exists('..\\' . DEF_CONTROLLER_PATH . '\\' . ucfirst($controller) . "Controller.php")) {
                if(substr(DEF_CONTROLLER_PATH, 0, 4) == 'app\\') {
                    $controllerPath = ucfirst(DEF_CONTROLLER_PATH . '\\' . ucfirst($controller) . "Controller");
                } else {
                    $controllerPath = DEF_CONTROLLER_PATH . '\\' . ucfirst($controller) . "Controller";
                }            
            } else {
                $controllerPath = $routes['error'];
            }
	}
        $this->controller = new $controllerPath($this->container);
    }

}