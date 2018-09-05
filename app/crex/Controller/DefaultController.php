<?php

namespace App\Crex\Controller;

use \Crex\Controller\Controller;

class DefaultController extends Controller {
        
    public function life() {
        $form = $this->container->getFactory('FormFactory')->create();
        $form
            ->setName('MainForm')
            ->add('fieldset', 'Fieldset A')
                ->setLabel('Fieldset A')
                ->add('text', 'first-textbox')
                    ->setLabel('First textbox')
                    ->setValue('Value of first textbox');
        $form->getComponent('Fieldset A')
                ->add('text', 'second-textbox')
                    ->setLabel('Second textbox');
        $form->getComponent('Fieldset A')
                ->add('password', 'first-password')
                    ->setLabel('First password');
        $form->add('fieldset', 'Fieldset B')
                ->setLabel('Fieldset B')
                ->add('checkbox', 'first-checkbox')
                    ->setLabel('Checkbox');
        $form->getComponent('Fieldset B')
                ->add('radio', 'first-radio')
                    ->addValue('value1', 'First value')
                    ->addValue('value2', 'Second value')
                    ->addValue('value3', 'Third value')
                    ->setRequired(1);
        $form->getComponent('Fieldset B')
                ->add('select', 'single-select')
                    ->setLabel('Single select')
                    ->setMultiple(1)
                    ->addOption('FirstOption', 'First option', 1)
                    ->addOption('SecondOption', 'Second option')
                    ->addOption('ThirdOption', 'Third option')
                    ->setSize(2);
        $this->setParameter('form', $form);
        
        $test_array = array(
            '1' => 'Hello',
            '2' => 'world',
            '3' => '!'
        );
        $this->setParameter('test_array', $test_array);
        
        $test_multiarray = array(
            'A' => ['A1', 'A2', 'A3'],
            'B' => ['B1', 'B2', 'B3']
        );
        $this->setParameter('test_multiarray', $test_multiarray);
    }
    
}