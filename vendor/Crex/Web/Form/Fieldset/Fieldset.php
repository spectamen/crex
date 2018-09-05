<?php

namespace Crex\Web\Form\Fieldset;

use Crex\Web\Form\AFormBlock;

class Fieldset extends AFormBlock {
    
    public function __toString() {
        $string = "\n<div class=\"crex-fieldset\">" . 
                  "\n<fieldset>";
        if(!empty($this->label)) {
            $string = $string .  "\n<legend>" . $this->name . "</legend>\n";
        }
        foreach($this->components as $component) {
            $string = $string . $component;
        }
        $string = $string . "</fieldset>"
                . "\n</div>\n";
        return $string;  
    }
    
}
