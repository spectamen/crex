<?php

namespace Crex\Web\Form\Textarea;

use Crex\Web\Form\AFormInput;

class Textarea extends AFormInput {
    
    public function setValue($value) {
        $this->addContent($value, 'value');
        return $this;
    }
    
    public function getValue() {
        return $this->getContentItem('value');
    }
}
