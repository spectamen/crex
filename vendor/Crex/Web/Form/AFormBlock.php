<?php

namespace Crex\Web\Form;

use Crex\Web\Item;

abstract class AFormBlock extends Item {
    
    abstract function loadValues($method);
    
    public function add($item, $name) {
        $contentItem = $this->returnNewContentItem($item, $name);
        return $this->addContent($contentItem, $name);
    }
    
    protected function returnNewContentItem($type, $name = NULL) {
        switch($type) {
            case 'fieldset':
                $contentItem = $this->container->getFactory('FormFieldsetFactory')->create();
                break;
            case 'text';
                $contentItem = $this->container->getFactory('FormInputFactory')->create($type, $name);
                break;
            case 'password':
                $contentItem = $this->container->getFactory('FormInputFactory')->create($type, $name);
                break;
            case 'checkbox':
                $contentItem = $this->container->getFactory('FormInputFactory')->create($type, $name);
                break;
            case 'select':
                $contentItem = $this->container->getFactory('FormSelectFactory')->create($name);
                break;
            default:
                $params['name'] = $type;
                $contentItem = $this->container->getFactory('WebItemFactory')->create($params);
                break;
        }
        return $contentItem;
    }
    
    protected function loadValuesGET() {
        foreach($_GET as $name => $value) {
            $this->fillUpValue($name, $value, 'GET');
        }
        return $this;
    }
    
    protected function loadValuesPOST() {
        foreach($_POST as $name => $value) {
            $this->fillUpValue($name, $value, 'POST');
        }
    }
    
    protected function fillUpValue($name, $value, $method) {
        foreach($this->getContent() as $contentItem) {
            if(is_a($contentItem, 'Crex\Web\Form\AFormBlock')) {
                $contentItem->loadValues($method);
            }
            else if($contentItem->attributes['name'] == $name) {
                $contentItem->setValue('value', $value);
            }
        }
        return $this;
    }
}
