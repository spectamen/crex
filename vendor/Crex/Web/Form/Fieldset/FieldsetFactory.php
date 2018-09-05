<?php

namespace Crex\Web\Form\Fieldset;

use Crex\Factory\Factory;

class FieldsetFactory extends Factory {
    
    public function create($name, $label = NULL) {
        return new Fieldset($this->container, array('name' => $name, 'label' => $label));
    }
    
}
