<?php

namespace crex\Database\Table;

use crex\Database\ADatabaseObject;
use crex\Exception\DatabaseException;

class Table extends ADatabaseObject {

    protected $columns = array();
    protected $database;
    protected $connection;
    private $columnFactory;
    private $rowFactory;

    public function __construct(\crex\Container\Container $container, array $parameters = NULL) {
        parent::__construct($container, $parameters);
        if (isset($parameters['name'])) {
            $this->name = $parameters['name'];
            $this->columnFactory = $this->container->getFactory('ColumnFactory');
            $this->rowFactory = $this->container->getFactory('RowFactory');
            $this->loadAllColumns();
        }
    }

    public function get($id = NULL) {
        $primary = $this->getPrimary();
        if ($primary === NULL AND $id !== NULL) {
            throw new DatabaseException('You can not load specific row of table ' . $this->name . '.The table does not have primary key included 1 column only. Use getWhere() instead.');
        }
        if ($id == NULL) {
            return $this->getData();
        }
        return $this->getData(array($primary->name => $id));
    }

    public function where(array $where) {
        return $this->getData($where);
    }

    public function draw() {
        echo(
        '&nbsp;&nbsp;&nbsp;&nbsp;[=] Table [' . $this->name . '] has ' . count($this->columns) . ' column(s): <br>'
        );
        foreach ($this->columns as $column) {
            $column->draw();
        }
    }
    
    public function getDatabase() {
        return $this->database;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function setDatabase($database) {
        $this->database = $database;
        return $this;
    }

    public function setConnection($connection) {
        $this->connection = $connection;
        return $this;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function setColumns($columns) {
        $this->columns = $columns;
        return $this;
    }

    private function loadAllColumns() {
        $columns = $this->connection->query('DESCRIBE ' . $this->name);
        foreach ($columns as $column) {
            $array = $this->normalizeColumnParameters($column);
            $array['table'] = $this;
            $array['database'] = $this->database;
            $array['connection'] = $this->connection;
            $this->columns[strtolower($column[0])] = $this->columnFactory->create($array);
        }
    }

    private function normalizeColumnParameters($column) {
        $nullable = false;
        $size = 0;
        $isPrimaryKey = false;
        $isAutoInc = false;
        if ($column['Null'] == 'YES') {
            $nullable = true;
        }
        if (strlen(str_replace(')', '', str_replace(substr($column['Type'], 0, strpos($column['Type'], '(') - 1), '', $column['Type']))) > 0) {
            $size = str_replace(')', '', str_replace(substr($column['Type'], 0, strpos($column['Type'], '(') - 1), '', $column['Type']));
        }
        if ($column['Key'] == 'PRI') {
            $isPrimaryKey = true;
        }
        if (strpos($column['Extra'], 'auto_inc') !== false) {
            $isAutoInc = true;
        }
        $array = array(
            'name' => strtolower($column['Field']),
            'dataType' => substr($column['Type'], 0, strpos($column['Type'], '(')),
            'size' => $size,
            'nullable' => $nullable,
            'defaultValue' => $column['Default'],
            'isPrimaryKey' => $isPrimaryKey,
            'isAutoInc' => $isAutoInc
        );
        return $array;
    }

    private function getPrimary() {
        $primary = NULL;
        foreach ($this->columns as $column) {
            if ($column->isPrimaryKey == TRUE) {
                return $column;
            }
        }
        return $primary;
    }

    private function getData(array $where = NULL) {
        $rows = array();
        if($where == NULL) {
            $where = array();
        }
        $datas = $this->connection->select($this->name, '*', $where);
        foreach ($datas as $data) {
            $rows[] = $this->rowFactory->create($this->columns, $data);
        }
        return $rows;
    }

}
