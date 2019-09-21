<?php

abstract class Service {
    protected static $db = null;

    protected function __construct() {
    }

    public static function serviceInitialize($db) {
        Service::$db = $db;
    }

    protected function mysql_bit1_to_boolean($input) {
        return ord(strval($input)) != 0;
    }

    protected function fetch($sql, $args) {
        $stmt = Service::$db->prepare(
            $sql, 
            []);
        if (!empty($args)) {
            foreach($args as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        $this->stmtExecute($stmt);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $record;
    }

    protected function fetchAll($sql, $args) {
        $stmt = Service::$db->prepare(
            $sql, 
            []);
        if (!empty($args)) {
            foreach($args as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        $this->stmtExecute($stmt);
        $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $record;
    }

    protected function fetchColumn($sql, $args) {
        $stmt = Service::$db->prepare(
            $sql, 
            []);
        if (!empty($args)) {
            foreach($args as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        $this->stmtExecute($stmt);
        $value = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $value;
    }

    protected function fetchAllColumn($sql, $args) {
        $stmt = Service::$db->prepare(
            $sql, 
            []);
        if (!empty($args)) {
            foreach($args as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        $this->stmtExecute($stmt);
        $value = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $stmt->closeCursor();
        return $value;
    }

    protected function stmtExecute($stmt) {
        try {
            if (!$stmt->execute()) {
                return false;
            } else {
                return $stmt->rowCount();
            }
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage()."\n".$stmt->queryString, $e->getCode(), $e);
        }
    }

    protected function execute($sql, $args) {
        $stmt = Service::$db->prepare(
            $sql, 
            []);
        if (!empty($args)) {
            foreach($args as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }

        $result = $this->stmtExecute($stmt);
        $stmt->closeCursor();
        return $result;
    }

    protected function update($tableName, $values, $where, $whereBindParams) {
        $sql = null;
        $params = null;
        $this->createUpdateSql($tableName, $values, $where, $whereBindParams, $sql, $params);
        return $this->execute($sql, $params);
    }

    protected function insert($tableName, $values) {
        $sql = null;
        $params = null;
        $this->createInsertSql($tableName, $values, $sql, $params);
        return $this->execute($sql, $params);
    }

    protected function insertOrUpdate($tableName, $values, $where, $whereBindParams) {
        $sql = 'select count(*) from '.$tableName.' where '.$where;
        $params = [];
        $count = $this->fetchColumn($sql, $whereBindParams);
        $mode = null;
        if ($count > 0) {
            $sql = $this->createUpdateSql($tableName, $values, $where, $whereBindParams, $sql, $params);
            $mode = 'update';
        } else {
            $sql = $this->createInsertSql($tableName, $values, $sql, $params);
            $mode = 'insert';
        }
        return [
            'mode' => $mode, 
            'rows' => $this->execute($sql, $params)
        ];
    }

    protected function createInsertSql($tableName, $values, &$sql, &$params) {
        $sql = 'insert into '.$tableName.' ';
        $sqlColumns = '';
        $sqlValues = '';

        foreach ($values as $key => $value) {
            if (!empty($sqlColumns) && !empty($sqlValues)) {
                $sqlColumns .= ',';
                $sqlValues .= ',';
            }
            $key = underscore($key);
            $sqlColumns .= $key;
            $sqlValues .= ':'.$key;
            $params[':'.$key] = $value;
        }
        $sql .= '('.$sqlColumns.') values ('.$sqlValues.')';
        return $sql;
    }

    protected function createUpdateSql($tableName, $values, $where, $whereBindParams, &$sql, &$params) {
        $sql = 'update '.$tableName.' set ';
        $updates = '';
        foreach ($values as $key => $value) {
            if (!empty($updates)) {
                $updates .= ',';
            }
            $key = underscore($key);
            $updates .= $key.' = :'.$key;
            $params[':'.$key] = $value;
        }
        foreach ($whereBindParams as $key => $value) {
            $params[$key] = $value;
        }
        $sql .= $updates.' where '.$where;
        return $sql;
    }
}