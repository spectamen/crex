<?php

namespace Crex\Web\Form\Input\Hidden;

use Crex\Web\Form\Input\AInput;
use Crex\Web\Form\Warning\FormWarning;

class Hidden extends AInput {
    
    public function __toString() {
        $string = "<input type=\"hidden\" name=\"" . $this->name . "\" value=\"" . $this->value . "\">";
        return $string;
    }
    
    public function setWidth($width) {
        FormWarning::ThrowWarning("Using <strong>width</strong> attribute for input of <strong>hidden</strong> type is not allowed by W3.org.");
        parent::setWidth($width);
        return $this;
    }
    
    public function setHeight($height) {
        FormWarning::ThrowWarning("Using <strong>height</strong> attribute for input of <strong>hidden</strong> type is not allowed by W3.org.");
        parent::setHeight($height);
        return $this;
    }
    
    public function setLabel($label) {
        FormWarning::ThrowWarning("Using <strong>label</strong> attribute for input of <strong>hidden</strong> type useless.");
        parent::setLabel($label);
        return $this;
    }
    
    public function setRequired($required) {
        FormWarning::ThrowWarning("Using <strong>required</strong> attribute for input of <strong>hidden</strong> type useless.");
        parent::setRequired($required);
        return $this;
    }
}
