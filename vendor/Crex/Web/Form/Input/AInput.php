<?php

namespace Crex\Web\Form\Input;

use Crex\Web\Form\AFormPart;

abstract class AInput extends AFormPart {
    
    protected $label;
    protected $value;
    protected $required = 0;
    protected $width;
    protected $height;
    
    public function drawLabel() {
        $string = "\n<div class=\"crex-form-input-label\">"
                . "\n<label for=\"" . $this->name . "\">" . $this->label . "</label>"
                . "\n</div>";
        echo($string);
    }
    
    public function getLabel() {
        return $this->label;
    }

    public function getValue() {
        return $this->value;
    }

    public function getRequired() {
        return $this->required;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setRequired($required) {
        $this->required = $required;
        return $this;
    }

    public function setWidth($width) {
        $this->width = $width;
        return $this;
    }

    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }
    
}
