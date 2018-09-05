<?php

namespace crex\Database\Table\Column;

use crex\Database\ADatabaseObject;

class Column extends ADatabaseObject {
    
    protected $table;
    protected $database;
    protected $connection;
    protected $isPrimaryKey;
    protected $isAutoInc;
    protected $dataType;
    protected $size;
    protected $nullable;
    protected $defaultValue;
    protected $relationsTo;
    protected $relationsFrom;
    
    public function __construct(\crex\Container\Container $container, $parameters) {
        parent::__construct($container, $parameters);
    }

    public function canBeValue($value) {
        #TODO
        return TRUE;
    }
    
    public function draw() {
        echo(
                '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* [' . $this->name . '] ' . $this->dataType . '');
        if($this->size > 0) {
            echo(
                    '(' . $this->size . ')');
        }
        if($this->nullable == false) {
            echo(
                    ' NOT NULL');
        } else {
            echo(
                    ' NULL');
        }
        if($this->isPrimaryKey == true) {
            echo(
                    ' PRIMARY KEY');
        }
        if($this->isAutoInc == true) {
            echo(
                    ' AUTOINC');
        }
        if($this->defaultValue) {
            echo(
                    ' {' . $this->defaultValue . '}');
        }
        echo(
                '<br>');
    }
    
    public function getRelationsTo() {
        return $this->relationsTo;
    }

    public function getRelationsFrom() {
        return $this->relationsFrom;
    }

    public function setRelationsTo($relationsTo) {
        $this->relationsTo = $relationsTo;
        return $this;
    }

    public function setRelationsFrom($relationsFrom) {
        $this->relationsFrom = $relationsFrom;
        return $this;
    }
    
    public function getTable() {
        return $this->table;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function setTable($table) {
        $this->table = $table;
        return $this;
    }

    public function setDatabase($database) {
        $this->database = $database;
        return $this;
    }

    public function setConnection($connection) {
        $this->connection = $connection;
        return $this;
    }
    
    public function getIsAutoInc() {
        return $this->isAutoInc;
    }

    public function setIsAutoInc($isAutoInc) {
        $this->isAutoInc = $isAutoInc;
        return $this;
    }
    
    public function getIsPrimaryKey() {
        return $this->isPrimaryKey;
    }

    public function setIsPrimaryKey($isPrimaryKey) {
        $this->isPrimaryKey = $isPrimaryKey;
        return $this;
    }
    
    public function getDataType() {
        return $this->dataType;
    }

    public function getSize() {
        return $this->size;
    }

    public function getNullable() {
        return $this->nullable;
    }

    public function getDefaultValue() {
        return $this->defaultValue;
    }

    public function setDataType($dataType) {
        $this->dataType = $dataType;
        return $this;
    }

    public function setSize($size) {
        $this->size = $size;
        return $this;
    }

    public function setNullable($nullable) {
        $this->nullable = $nullable;
        return $this;
    }

    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
        return $this;
    }
    
    public function assignRelations() {
        $this->loadRelationsFrom();
        $this->loadRelationsTo();
    }
    
    private function loadRelationsTo() {
        foreach($this->database->relations as $relation) {
            if($relation['table'] == $this->table->name and $relation['column'] == $this->name) {
                $table = $this->database->tables[$relation['ref_table']];
                $column = $table->columns[$relation['ref_column']];
                $this->relationsTo[] = array('table' => $table, 'column' => $column);
            }
        }
    }
    
    private function loadRelationsFrom() {
        foreach($this->database->relations as $relation) {
            if($relation['ref_table'] == $this->table->name and $relation['ref_column'] == $this->name) {
                $table = $this->database->tables[$relation['table']];
                $column = $table->columns[$relation['column']];
                $this->relationsFrom[] = array('table' => $table, 'column' => $column);
            }
        }
    }
    
}
