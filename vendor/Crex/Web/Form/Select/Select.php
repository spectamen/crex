<?php

namespace Crex\Web\Form\Select;

use Crex\Web\Form\AFormInput;

class Select extends AFormInput {
    
    public function addOption($value, $label, $selected = 0, $shifted = 0) {
        $contentItem = $this->returnNewContentItem('option');
        $contentItem->addAttribute('value', $value)
                ->addContent($label, 'label');
        if($selected == 1) {
            $contentItem->addAttribute('selected');
        }
        $this->addContent($contentItem, 'option_' . $value, 0, $shifted);
        return $this;
    }
    
    public function setValue($value) {
        foreach($this->content as $content) {
            if($content->value == $value) {
                $content->addAttribute('selected');
            } else {
                $content->removeAttribute('selected');
            }
        }
    }
    
    public function removeOption($value) {
        unset($this->content['option_' . $value]);
        return $this;
    }
    
    public function setSize($size) {
        $this->getAttributes()['size'] = $size;
        return $this;
    }
    
    public function setRequired() {
        parent::setRequired();
        $this->addOption('', '&nbsp;', 0, 1); //addEmptyOption
        return $this;
    }
    
    public function unsetRequired() {
        parent::unsetRequired();
        $this->removeOption('');
        return $this;
    }
    
}
