<?php

namespace Crex\Web\Form;

use Crex\Web\Form\AFormPart;

abstract class AFormBlock extends AFormPart {
    
    protected $components = array();
    
    private $factories = array();
    
    public function __construct(\crex\Container\Container $container, array $parameters = NULL) {
        parent::__construct($container, $parameters);
        $this->factories['FormFieldsetFactory'] = $this->container->getFactory('FormFieldsetFactory');
        $this->factories['FormTextFactory'] = $this->container->getFactory('FormTextFactory');
        $this->factories['FormPasswordFactory'] = $this->container->getFactory('FormPasswordFactory');
        $this->factories['FormCheckboxFactory'] = $this->container->getFactory('FormCheckboxFactory');
        $this->factories['FormRadioFactory'] = $this->container->getFactory('FormRadioFactory');
        $this->factories['FormHiddenFactory'] = $this->container->getFactory('FormHiddenFactory');
        $this->factories['FormSelectFactory'] = $this->container->getFactory('FormSelectFactory');
        return $this;
    }
    
    public function add($type, $name) {
        switch ($type) {
            case('fieldset'):
                return $this->addFieldset($name);
            case('text'):
                return $this->addText($name);
            case('password'):
                return $this->addPassword($name);
            case('checkbox'):
                return $this->addCheckbox($name);
            case('radio'):
                return $this->addRadio($name);
            case('hidden'):
                return $this->addHidden($name);
            case('select'):
                return $this->addSelect($name);
            default:
                throw new Exception\FormException('Unknown type of form part. Type <strong>' . $type . '</strong> is not defined.');
        }
    }
    
    public function setComponents($components) {
        $this->components = $components;
        return $this;
    }
    
    public function getComponents() {
        return $this->components;
    }
    
    public function getComponent($name) {
        return $this->components[$name];
    }
    
    private function addFieldset($name) {
        return $this->components[$name] = $this->factories['FormFieldsetFactory']->create($name);
    }
    
    private function addText($name) {
        return $this->components[$name] = $this->factories['FormTextFactory']->create($name);
    }
    
    private function addPassword($name) {
        return $this->components[$name] = $this->factories['FormPasswordFactory']->create($name);
    }
    
    private function addCheckbox($name) {
        return $this->components[$name] = $this->factories['FormCheckboxFactory']->create($name);
    }
    
    private function addRadio($name) {
        return $this->components[$name] = $this->factories['FormRadioFactory']->create($name);
    }
    
    private function addHidden($name) {
        return $this->components[$name] = $this->factories['FormHiddenFactory']->create($name);
    }
    
    private function addSelect($name) {
        return $this->components[$name] = $this->factories['FormSelectFactory']->create($name);
    }
}
