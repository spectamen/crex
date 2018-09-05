<?php

namespace crex\Database;

use crex\Exception\DatabaseException;
use crex\Helper\ArrayHelper;

class Database extends ADatabaseObject {
    
    protected $tables = array();
    protected $relations = array();
    private $tableFactory;
    
    public function __construct(\crex\Container\Container $container, array $parameters = NULL) {
        parent::__construct($container, $parameters);
        $this->connection = $this->container->getService('Connection');
        $this->tableFactory = $this->container->getFactory('TableFactory');
        $this->loadAllTables();
        $this->loadAllRelations();
        return $this;
    }
    
    public function table($name) {
        if(isset($this->tables[$name])) {
            return $this->tables[$name];
        } else {
            $nearest = ArrayHelper::getNearest(array_keys($this->tables), $name);
            throw new DatabaseException('Database does not contains table ' . $name . '. Did you mean ' . $nearest . '?');
        }
    }    
    
    public function getTables() {
        return $this->tables;
    }
    
    public function draw() {
        echo(
                '{==} Database ' . $this->name . ' contains ' . count($this->tables) . ' table(s): <br>'
                );
        foreach($this->tables as $table) {
            $table->draw();
        }
    }
    
    public function getRelations() {
        return $this->relations;
    }

    public function setRelations($relations) {
        $this->relations = $relations;
        return $this;
    }

    public function setTables($tables) {
        $this->tables = $tables;
        return $this;
    }
    
    private function loadAllTables() {
        $result = $this->connection->query('SHOW TABLES');
        foreach($result as $table)  {
            $this->tables[$table[0]] = $this->tableFactory->create(array(
                'name' => $table[0], 
                'database' => $this, 
                'connection' => $this->connection));
        }
    }
    
    private function loadAllRelations() {
        $result = $this->connection->query('
            SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE
            WHERE CONSTRAINT_SCHEMA = :dbname AND CONSTRAINT_NAME != :primary', array('dbname' => DB_DATABASE, 'primary' => 'PRIMARY'));
        foreach($result as $row) {
            $this->relations[] = array(
                'table' => strtolower($row['TABLE_NAME']),
                'column' => strtolower($row['COLUMN_NAME']),
                'ref_table' => strtolower($row['REFERENCED_TABLE_NAME']),
                'ref_column' => strtolower($row['REFERENCED_COLUMN_NAME']));
        }
    }
        
}
