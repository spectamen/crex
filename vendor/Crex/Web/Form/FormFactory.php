<?php

namespace crex\Web\Form;

use crex\Factory\Factory;

class FormFactory extends Factory  {
    
    public function create() {
        return new Form($this->container);
    }
    
}
