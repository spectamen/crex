<?php

namespace Crex\Web\Form\Fieldset;

use Crex\Factory\Factory;

class FieldsetFactory extends Factory {
    
    public function create() {
        return new Fieldset($this->container, array('name' => 'fieldset'));
    }
    
}
