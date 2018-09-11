<?php

namespace Crex\Web\Form;

class Form extends AFormBlock {
    
    private $allowedMethods = array(
        'GET',
        'POST'
    );
        
    public function setMethod($method) {
        if(!in_array(strtoupper($method), $this->allowedMethods)) {
            throw new WebItemException('WebItem Form does not allow value ' . $method . 'as attribute method');
        }
        $this->addAttribute('method', strtoupper($method));  
        return $this;
    }
    
    public function setAction($action) {
        $this->addAttribute('action', $action);
        return $this;
    }
    
    public function setTarget($target) {
        $this->addAttribute('target', $target);
        return $this;
    }
    
    public function loadValues($method = NULL) {
        (!isset($method)) ? $method = $this->attributes['method'] : $method = $method;
        switch($method) {
            case('GET'):
                $this->loadValuesGET();
                break;
            case('POST'):
                $this->loadVALUESPOST();
                break;
            default:
                break;
        }
        return $this;
    }
    
}
