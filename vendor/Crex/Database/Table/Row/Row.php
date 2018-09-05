<?php

namespace crex\Database\Table\Row;

use crex\Database\ADatabaseObject;
use crex\Helper\ArrayHelper;

class Row extends ADatabaseObject {

    protected $columns = array();
    protected $values = array();
    private $valueFactory;

    public function __construct(\crex\Container\Container $container, array $columns, array $values = NULL) {
        parent::__construct($container);
        $this->valueFactory = $this->container->getFactory('ValueFactory');
        $this->columns = $columns;
        $loweredValues = array();
        foreach($values as $key => $value) {
            $loweredValues[strtolower($key)] = $value;
        }
        foreach($this->columns as $column) {
            $value = NULL;
            if(isset($loweredValues[$column->name])) {
                $value = $loweredValues[$column->name];
            }
            $this->values[$column->name] = $this->valueFactory->create($column, $value);            
        }
        foreach ($loweredValues as $key => $value) {
            $this->values[$key]->setValue($value);
        }
        return $this;
    }
    
    public function __get($name) {
        $name = strtolower($name);
        if(isset($this->values[$name])) {
            return $this->values[$name];
        }
        $nearest = ArrayHelper::getNearest(array_keys($this->values), $name);
        throw new \crex\Exception\DatabaseException('Can not find column ' . $name . '. Did you mean ' . $nearest . '?');
        
    }
    
    public function __set($name, $value) {
        $name = strtolower($name);
        if(isset($this->values[$name])) {
            $this->values[$name] = $value;
            return $this;
        }
        $nearest = ArrayHelper::getNearest(array_keys($this->values), $name);
        throw new \crex\Exception\DatabaseException('Can not find column ' . $name . '. Did you mean ' . $nearest . '?');
        
    }            
    
    public function getValue($name) {
        return $this->values[$name];
    }

    public function draw() {
        #TODO
        echo('crexRow(');
        foreach($this->values as $name => $value) {
            echo('<br>&nbsp;&nbsp;' . $name . " => " . $value . ";");
        }
        echo('<br>);');
    }

    private function getColumn($name) {
        foreach ($this->columns as $column) {
            if ($column->name == $name) {
                return $column;
            }
        }
        return FALSE;
    }

}
