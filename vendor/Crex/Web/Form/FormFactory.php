<?php

namespace Crex\Web\Form;


class FormFactory extends \Crex\Factory\Factory {
    
    public function create($name = NULL) {
        $item = new Form($this->container, array('name' => 'form'));
	if($name) {
	    $item->addAttribute('name', $name);
	    $item->addAttribute('id', $name);
	}
	return $item;
    }   
    
}
