<?php

namespace Crex\Web\Form;


class FormFactory extends \Crex\Factory\Factory {
    
    public function create() {
        return new Form($this->container, array('name' => 'form'));
    }   
    
}
