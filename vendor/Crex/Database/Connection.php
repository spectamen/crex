<?php

namespace crex\Database;

use crex\Container\Container;
use crex\Service\Service;
use Medoo\Medoo;

class Connection extends Service {
    
    private $connection;
    
    public function __construct(Container $container, array $parameters = NULL) {
        parent::__construct($container, $parameters);
        return $this;
    }
    
    private function connect() {
        $this->connection = new Medoo(
                array(  'database_type' => 'mysql',
                        'database_name' => DB_DATABASE,
                        'server' => DB_SERVER,
                        'username' => DB_USERNAME,
                        'password' => DB_PASSWORD,
                        'charset' => 'utf8'));        
    }
    
    public function query(string $query, array $params = array()) {
        if($this->connection == NULL) {
            $this->connect();
        }
        return $this->connection->query($query, $params);
    }
    
    public function select($table, $join, $columns = NULL, $where = NULL) {
        if($this->connection == NULL) {
            $this->connect();
        }
        return $this->connection->select($table, $join, $columns, $where);
    }
    
    public function last() {
        if($this->connection == NULL) {
            $this->connect();
        }
        return $this->connection->last();
    }
    
}
