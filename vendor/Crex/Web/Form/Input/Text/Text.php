<?php

namespace Crex\Web\Form\Input\Text;

use Crex\Web\Form\Input\AInput;
use Crex\Web\Form\Warning\FormWarning;

class Text extends AInput {
    
    public function __toString() {
        $string = "<div class=\"crex-form-input\">" .
                  "<div class=\"crex-form-input-label\">" .
                  "<label for=\"" . $this->name . "\">" . $this->label . "</label>" .
                  "</div>" .
                  "<div class=\"crex-form-input-text\">" .
                  "<input type=\"text\" id=\"" . $this->name . "\" name=\"" . $this->name . "\"";
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
                  "</div>" . 
                  "</div>";
        return $string;
    }
    
    public function setWidth($width) {
        FormWarning::ThrowWarning("Using <strong>width</strong> attribute for input of <strong>text</strong> type is not allowed by W3.org.");
        parent::setWidth($width);
        return $this;
    }
    
    public function setHeight($height) {
        FormWarning::ThrowWarning("Using <strong>height</strong> attribute for input of <strong>text</strong> type is not allowed by W3.org.");
        parent::setHeight($height);
        return $this;
    }
    
}
