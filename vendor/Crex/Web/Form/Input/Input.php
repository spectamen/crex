<?php

namespace Crex\Web\Form\Input;

use Crex\Web\Form\AFormInput;

class Input extends AFormInput {
    
    public function setValue($value) {
        $this->addAttribute('value', $value);
        return $this;
    }
    
    public function getValue() {
        return $this->getAttributes()['value'];
    }
       
}
