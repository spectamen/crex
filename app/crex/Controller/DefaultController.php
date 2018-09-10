<?php

namespace App\Crex\Controller;

use \Crex\Controller\Controller;

class DefaultController extends Controller {
        
    public function life() {
        $this->createForm();
        $this->createAnotherForm();
    }
    
    private function createForm() {
        $form = $this->container->getFactory('FormFactory')->create()
                ->setMethod('get')
                ->setAction('index.php')
                ->setTarget('_blank');
        $form->add('fieldset', 'FA')
                ->setLegend('Fieldset A');
        $form->getContentItem('FA')
                ->add('text', 'FirstTextbox')
                    ->setLabel('1. textbox')
                    ->setValue('First textbox has value.');
        $form->getContentItem('FA')
                ->add('text', 'SecondTextbox')
                    ->setLabel('2. textbox');
        $fa = $form->getContentItem('FA');
        $fa->add('password', 'Password')->setLabel('Password');
        $fa->add('password', 'PasswordAgain')->setLabel('Password again');
        $fa->add('checkbox', 'Checkbox')
                ->setLabel('This is checkbox')
                ->addAttribute('checked');
        $this->setParameter('form', $form);
    }
    
    public function createAnotherForm() {
        $form = $this->container->getFactory('FormFactory')->create()
                ->setMethod('get')
                ->setAction('index.php')
                ->setTarget('_blank');
        
        $selectionBox = $this->container->getFactory('FormSelectFactory')->create('SelectionBox', 2);
        $selectionBox
                ->setLabel('Two row-size select')
                ->addOption('1', 'First')
                ->addOption('2', 'Second')
                ->addOption('3', 'Third', 1); //selected
        $form->addContent($selectionBox, 'selectionBox');
        $form->add('select', 'Color')
                ->setLabel('One row-size select (required)')
                ->addOption('1', 'Red')
                ->addOption('2', 'Blue')
                ->addOption('3', 'Green')
                ->addOption('4', 'White')
                ->setSize(1)
                ->setRequired();
        $this->setParameter('anotherForm', $form);
    }
    
}