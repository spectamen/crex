<?php

namespace Crex\Web\Form;

use Crex\CrexObject;

abstract class AFormPart extends CrexObject {
    
    protected $name;
    protected $label;
    
    abstract function __toString();
    
    public function getName() {
        return $this->name;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }
    
}
