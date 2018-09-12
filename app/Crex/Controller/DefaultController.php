<?php

namespace App\Crex\Controller;

use \Crex\Controller\Controller;

class DefaultController extends Controller {
        
    public function life() {
        $form = $this->newForm('ExampleForm')
		->setMethod('GET');
	
	$fieldset = $form->add('fieldset', 'PersonalInformation')
		->setLegend('Personal Information');
	
	$fieldset->add('text', 'FirstName')
		->setLabel('First name:')
		->setRequired();
	
	$fieldset->add('text', 'MiddleName')
		->setLabel('Middle name:');
	
	$fieldset->add('text', 'LastName')
		->setLabel('Last name:')
		->setRequired();
	
	$fieldset->add('email', 'Email')
		->setLabel('E-mail:')
		->setRequired()
		->setValue('@');
	$fieldset->add('submit', 'Submit')
		->setValue('Send');
	
	$fieldset = $form->add('fieldset', 'CodeReview')
		->setLegend('Code review');
	$fieldset->add('textarea', 'Code')
		->addAttribute('cols', 60)
		->addAttribute('rows', 15)
		->setValue("\$form = \$this->newForm('ExampleForm')
    ->setMethod('GET');\n
\$fieldset = \$form->add('fieldset', 'PersonalInformation')
    ->setLegend('Personal Information');\n
\$fieldset->add('text', 'FirstName')
    ->setLabel('First name:')
    ->setRequired();\n
\$fieldset->add('text', 'MiddleName')
    ->setLabel('Middle name:');\n
\$fieldset->add('text', 'LastName')
    ->setLabel('Last name:')
    ->setRequired();\n
\$fieldset->add('email', 'Email')
    ->setLabel('E-mail:')
    ->setRequired()
    ->setValue('@');\n
\$fieldset->add('submit', 'Submit')
    ->setValue('Send');");
	
    }
        
}