<?php

namespace Crex\Web\Form\Input\Password;

use Crex\Web\Form\Input\AInput;

class Password extends AInput {
    
    public function __toString() {
        $string = "\n<div class=\"crex-form-input\">" .
                  "\n   <div class=\"crex-form-input-label\">" .
                  "\n       <label for=\"" . $this->name . "\">" . $this->label . "</label>" .
                  "\n   </div>" .
                  "\n   <div class=\"crex-form-input-password\">" .
                  "\n       <input type=\"password\" id=\"" . $this->name . "\" name=\"" . $this->name . "\"";
        if($this->required !== 0) {
            $string = $string . " required";
        }
        if(!empty($this->value)) {
            $string = $string . " value=\"" . $this->value . "\"";
        }
        if(!empty($this->width)) {
            $string = $string . " width=\"" . $this->width . "\"";
        }
        if(!empty($this->height)) {
            $string = $string . " height=\"" . $this->height . "\"";
        }
        $string = $string . ">" .
                  "\n   </div>" . 
                  "\n</div>";
        return $string;
    }
    
}
