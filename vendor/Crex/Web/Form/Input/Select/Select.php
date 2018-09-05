<?php

namespace Crex\Web\Form\Input\Select;

use Crex\Web\Form\Input\AInput;

class Select extends AInput {
    
    protected $options = array();
    protected $pickedOptions = array();
    protected $size = 1;
    protected $multiple = 0;
    
    public function __toString() {
        $string = "\n<div class=\"crex-form-select\" id=\"" . $this->name . "\">";
        $string = $string . "\n<div class=\"crex-form-select-label\">";
        $string = $string . "\n<label>" . $this->label . "</label>";
        $string = $string . "\n</div>";
        $string = $string . "\n<select name=\"" . $this->name . "\" size=" . $this->size;
        if($this->multiple == 1) {
            $string = $string . " multiple";
        }
        if($this->required == 1) {
            $string = $string . " required";
        }
        $string = $string . ">";
        $string = $string . $this->optionsToString();
        $string = $string .
                "\n</select>\n</div>";
        return $string;
    }
    
    public function setSize($size) {
        $this->size = $size;
        return $this;
    }
    
    public function getSize() {
        return $this->size;
    }
    
    public function setMultiple($multiple) {
        $this->multiple = $multiple;
        return $this;
    }
    
    public function getMultiple() {
        return $this->multiple;
    }
    
    public function setValue($value) {
        FormWarning::throwWarning('Class Crex\Web\Form\Input\Select has useless property <strong>Value</strong>. Did you want to edit some option?');
    }
    
    public function getOptions() {
        return $this->values;
    }
    
    public function addOption($value, $label, $selected = 0) {
        $this->options[$value] = array("label" => $label, "selected" => $selected);
        return $this;
    }
        
    public function removeOption($value) {
        if(isset($this->options[$value])) {
            unset($this->options[$value]);
        }
        return $this;
    }
    
    public function selectOption($value) {
        if(!isset($this->options[$value])) {
            throw new FormException('Option <strong>' . $value . '</strong> does not exist in select <strong>' . $this->name . '</strong>.');
        }
        $this->options[$value]['selected'] = 1;
        return $this;
    }
    
    public function unselectOption($value) {
        if(!isset($this->options[$value])) {
            throw new FormException('Option <strong>' . $value . '</strong> does not exist in select <strong>' . $this->name . '</strong>.');
        }
        $this->options[$value]['selected'] = 0;
        return $this;
    }
    
    private function optionsToString() {
        $string = "";
        foreach($this->options as $value => $array) {
            $string = $string . 
                    "\n<option value=\"" . $value . "\"";
            if($array['selected'] == 1) {
                $string = $string . " selected";
            }
            $string = $string . ">" . $array['label'];
        }
        return $string;
    }
}
