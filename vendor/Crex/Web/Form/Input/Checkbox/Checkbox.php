<?php

namespace Crex\Web\Form\Input\Checkbox;

use Crex\Web\Form\Input\AInput;

class Checkbox extends AInput {
    
    public function __construct(\crex\Container\Container $container, array $parameters = NULL) {
        parent::__construct($container, $parameters);
        $this->value = 0;
    }
    
    public function __toString() {
        $string = "\n<div class=\"crex-form-input\">" .
                  "\n   <div class=\"crex-form-input-label\">" .
                  "\n       <label for=\"" . $this->name . "\">" . $this->label . "</label>" .
                  "\n   </div>" .
                  "\n   <div class=\"crex-form-input-checkbox\">" .
                  "\n       <input type=\"checkbox\" id=\"" . $this->name . "\" name=\"" . $this->name . "\" value=\"1\"";
        if($this->value == 1) {
            $string = $string . " checked";
        }
        $string = $string . ">" .
                  "\n   </div>" . 
                  "\n</div>";
        return $string;
    }
    
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    
}
