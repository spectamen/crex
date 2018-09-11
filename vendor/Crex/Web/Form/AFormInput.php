<?php

namespace Crex\Web\Form;

use Crex\Web\Item;

abstract class AFormInput extends Item {
    
    abstract function setValue($value);
    
    public function setRequired() {
        $this->addAttribute('required');
        return $this;
    }
    
    public function unsetRequired() {
        if(isset($this->attributes['required'])) {
            unset($this->attributes['required']);
        }
        return $this;
    }
    
    public function setLabel($label, $pre = 1) {
        $this->addAttribute('id', $this->getAttributes()['name']);
        $contentItem = $this->returnNewContentItem('label');
        $contentItem->addContent($label, 'label');
        $contentItem->addAttribute('for', $this->attributes['name']);
        $this->addContent($contentItem, 'label', $pre);
        return $this;
    }
    
    protected function returnNewContentItem($type, $params = array()) {
        switch($type) {
            default:
                $params['name'] = $type;
                $contentItem = $this->container->getFactory('WebItemFactory')->create($params);
        }
        return $contentItem;
    }
    
}
