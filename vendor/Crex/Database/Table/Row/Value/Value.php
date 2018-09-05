<?php

namespace crex\Database\Table\Row\Value;

use crex\Database\ADatabaseObject;

class Value extends ADatabaseObject {
    
    protected $column;
    protected $value;
    
    public function __construct(\crex\Container\Container $container, $column, $value = NULL) {
        parent::__construct($container);
        $this->column = $column;
        $this->value = $value;
        return $this;
    }
    
    public function setValue($value) {
        if($this->column->canBeValue($value)) {
            $this->value = $value;
        }
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function __toString() {
        return $this->value;
    }
    
    public function to() {
        $row = NULL;
        $this->column->assignRelations();
        $relation = $this->column->relationsTo[0];
        if($relation == NULL) {
            throw new \crex\Exception\DatabaseException('There is no RELATION TO for column ' . $this->column->name . ' of table ' . $this->column->table->name . '.');
        }
        $row = $relation['table']->where(array($relation['column']->name => $this->value))[0];
        return $row;
    }
    
    public function from($table, $column = NULL) {
        $rows = array();
        $rel = NULL;
        $this->column->assignRelations();
        $relations = $this->column->relationsFrom;
        foreach($relations as $relation) {
            if($relation['table']->name == $table and $relation['column']->name == $column) {
                $rel = $relation;
            }
        }
        if($rel == NULL) {
            
            throw new \crex\Exception\DatabaseException('There is not RELATION FROM for column' . $this->column->name . ' of table ' . $this->column->table->name . '.');
        }
        $rows = $rel['table']->where(array($rel['column']->name => $this->value));
        return $rows;
    }    
}
