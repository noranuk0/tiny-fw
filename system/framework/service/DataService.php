<?php
class DataService extends Service {
    private static $instance;

    public static function instance() {
        if (DataService::$instance == null) {
            DataService::$instance = new DataService();
        }
        return DataService::$instance;
    }

    public function all($tableName, $sortKey='id') {
        if (preg_match('/^[a-zA-Z0-9_\.]+$/', $tableName) !== 1) {
            return null;
        }   
        $sql =
<<<SQL
            select * from $tableName order by :sort_key
SQL;
        $bindValues = [':sort_key' => $sortKey];
        return $this->fetchAll($sql, $bindValues);
    }

    public function find($tableName, $where, $whereBindParams) {
        if (preg_match('/^[a-zA-Z0-9_\.]+$/', $tableName) !== 1) {
            return null;
        }
        $sql = 
<<<SQL
            select * from $tableName where $where
SQL;
        return $this->fetch($sql, $whereBindParams);
    }

    public function count($tableName, $where, $whereBindParams) {
        if (preg_match('/^[a-zA-Z0-9_\.]+$/', $tableName) !== 1) {
            return null;
        }
        $sql = 
<<<SQL
            select count(*) from $tableName where $where
SQL;
        return $this->fetchColumn($sql, $whereBindParams);
    } 

    public function findAll($tableName, $where, $whereBindParams, $sortKey) {
        if (preg_match('/^[a-zA-Z0-9_\.]+$/', $tableName) !== 1) {
            return null;
        }
        $sql = 
<<<SQL
            select * from $tableName where $where order by $sortKey
SQL;
        return $this->fetchAll($sql, $whereBindParams);
    }

    public function distinct($tableName, $columnName, $sortKey) {
        if (preg_match('/^[a-zA-Z0-9_\.]+$/', $tableName) !== 1 ||
            preg_match('/^[a-zA-Z0-9_\.]+$/', $columnName) !== 1) {
            return null;
        }
        $sql = 
<<<SQL
            select distinct $columnName from $tableName order by $sortKey
SQL;
        return $this->fetchAllColumn($sql, []);
    }

    public function findColumnBy($tableName, $columnName, $where, $whereBindParams, $sortKey) {
        if (preg_match('/^[a-zA-Z0-9_\.]+$/', $tableName) !== 1 ||
            preg_match('/^[a-zA-Z0-9_\.]+$/', $columnName) !== 1) {
            return null;
        }
        $sql = 
<<<SQL
            select $columnName from $tableName where $where order by $sortKey
SQL;
        return $this->fetchAllColumn($sql, $whereBindParams);
    }

    public function insertOrUpdate($tableName, $values, $where, $whereBindParams) {
        return parent::insertOrUpdate($tableName, $values, $where, $whereBindParams);
    }

    public function update($tableName, $values, $where, $whereBindParams) {
        return parent::update($tableName, $values, $where, $whereBindParams);
    }

    public function insert($tableName, $values) {
        return parent::insert($tableName, $values);
    }

    public function truncate($tableName) {
        if (preg_match('/^[a-zA-Z0-9_\.]+$/', $tableName) !== 1) {
            return null;
        }
        $sql = 
<<<SQL
            truncate $tableName
SQL;
        return parent::execute($sql, []);
    }

    public function delete($tableName, $where, $whereBindParams) {
        if (preg_match('/^[a-zA-Z0-9_\.]+$/', $tableName) !== 1) {
            return null;
        }
        $sql = 
<<<SQL
            delete from $tableName where $where
SQL;
        return parent::execute($sql, $whereBindParams);
    }
}
