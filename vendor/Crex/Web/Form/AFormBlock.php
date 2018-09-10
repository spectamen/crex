<?php

namespace Crex\Web\Form;

use Crex\Web\Item;

abstract class AFormBlock extends Item {
    
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
    
}
