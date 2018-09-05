<?php

namespace crex\Container;

use Nette\Neon\Neon;
use crex\Helper\LogHelper;

class Container {
    
    private $services = array();
    private $factories = array();
    private $templates = array();
    private $parameters = array();
    
    public function __construct() {
        $this->parameters = $this->getParsedAddress();
    }
    
    public function getUID() {
        return spl_object_hash($this);
    }
    
    public function getParameters() {
	return $this->parameters;
    }
    
    public function getTemplates() {
        return $this->templates;
    }
    
    public function setParameter($name, $value) {
        $this->parameters[$name] = $value;
        return $this;
    }
    
    public function setTemplate($name, $value) {
        $this->templates[$name] = $value;
    }
    
    private function getParsedAddress() {
	$actual_link = "http://" . filter_input(INPUT_SERVER, 'HTTP_HOST') . filter_input(INPUT_SERVER, 'REQUEST_URI');
        $actual_link = str_replace(ADDRESS, "", $actual_link);
	$array = explode("/", $actual_link);
        return array_slice($array, 0, count($array) - 1);
    }
    
    public function getService($serviceName) {
        if(!isset($this->services[$serviceName])) {
            $services = Neon::decode(file_get_contents('../app/services.neon'));
            if(isset($services[$serviceName])) {
                $servicePath = $services[$serviceName];
            } else {
                if(file_exists('..\\' . DEF_SERVICE_PATH . '\\' . ucfirst($serviceName) . ".php")) {
                    if(substr(DEF_SERVICE_PATH, 0, 4) == 'app\\') {
                        $servicePath = ucfirst(DEF_SERVICE_PATH . '\\' . ucfirst($serviceName) . "");
                    } else {
                        $servicePath = DEF_SERVICE_PATH . '\\' . ucfirst($serviceName) . "";
                    }            
                } else {
                    throw new \Exception('Can not create service ' . $serviceName . '. Service is not defined.');
                }
            }
            $this->services[$serviceName] = new $servicePath($this);
        }
        return $this->services[$serviceName];
    }
    
    public function getFactory($factoryName) {
        if(!isset($this->factories[$factoryName])) {
            $factories = Neon::decode(file_get_contents('../app/factories.neon'));
            if(isset($factories[$factoryName])) {
                $factoryPath = $factories[$factoryName];
            } else {
                if(file_exists('..\\' . DEF_FACTORY_PATH . '\\' . ucfirst($factoryName) . ".php")) {
                    if(substr(DEF_FACTORY_PATH, 0, 4) == 'app\\') {
                        $factoryPath = ucfirst(DEF_FACTORY_PATH . '\\' . ucfirst($factoryName) . "");
                    } else {
                        $factoryPath = DEF_FACTORY_PATH . '\\' . ucfirst($factoryName) . "";
                    }            
                } else {
                    throw new \Exception('Can not create factory ' . $factoryName . '. Factory is not defined.');
                }
            }
            $this->factories[$factoryName] = new $factoryPath($this);
        }
        return $this->factories[$factoryName];
    }
    
}
