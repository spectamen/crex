<?php

namespace Crex\Web\Form\Input\Radio;

use Crex\Web\Form\Input\AInput;
use Crex\Web\Form\Warning\FormWarning;
use Crex\Web\From\Exception\FormException;

class Radio extends AInput {
    
    protected $values = array();
    protected $pickedValue;
    
    public function __toString() {
        $string = "\n<div class=\"crex-input-radio-field\" id=\"" . $this->name . "\">";;
        $string = $string . $this->valuesToString();
        $string = $string . "\n</div>";
        return $string;
    }
    
    public function setValue($value) {
        FormWarning::throwWarning('Class Crex\Web\Form\Input\Radio has useless property <strong>Value</strong>. Did you want to edit some Radio button choice?');
    }
    
    public function getValues() {
        return $this->values;
    }
    
    public function addValue($value, $label, $picked = 0) {
        $this->values[$value] = $label;
        if($picked == 1) {
            $this->pickedValue($value);
        }
        return $this;
    }
        
    public function removeValue($value) {
        if(isset($this->values[$value])) {
            unset($this->values[$value]);
        }
        return $this;
    }
    
    public function pickValue($value) {
        if(!isset($this->values[$value])) {
            throw new FormException('Value <strong>' . $value . '</strong> does not exist in radio <strong>' . $this->name . '</strong>.');
        }
        $this->pickedValue = $value;
        return $this;
    }
    
    private function valuesToString() {
        $string = "";
        foreach($this->values as $value => $label) {
            $string = $string . 
                    "\n<input type=\"radio\" name=\"" . $this->name . "\" value=\"" . $value . "\" id=\"" . $this->name . ":" . $value . "\"";
            if($this->required == 1) {
                $string = $string . " required";
            }
            if($this->pickedValue == $value) {
                $string = $string . " checked";
            }
            $string = $string . "><label for=\"" . $this->name . ":" . $value . "\">" . $label . "</label>";
        }
        return $string;
    }
}
