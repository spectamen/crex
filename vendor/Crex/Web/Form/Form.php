<?php

namespace Crex\Web\Form;

use Crex\Web\Form\AFormBlock;

class Form extends AFormBlock {
    
    protected $action = "GET";
    
    public function __toString() {
        $string = "<div class=\"crex-form\">"
                . "<form action=\"" . $this->action . "\"";
        if(!empty($this->name)) {
            $string = $string . " id=\"" . $this->name . "\"";
        }
        $string = $string . ">";
        foreach($this->components as $component) {
            $string = $string . $component;
        }
        $string = $string . "</form>"
                . "</div>\n";
        return $string;
    }
    
    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        if($action == "POST" or $action == "GET") {
            $this->action = $action;
        } else {
            throw new Exception\FormException("Error when setting action for Form. Action <strong>" . $action . "</strong> is not allowed.");
        }        
        return $this;
    }

}
