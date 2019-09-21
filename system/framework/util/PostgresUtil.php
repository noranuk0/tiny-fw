<?php

class PostgresUtil {
    public static function pg_date_to_php_date($data) {
        return DateTime::createFromFormat('Y-m-d H:i:s', $data);
    }

    public static function php_array_to_pg_array($data) {
        if (!empty($data)) {
            if (is_array($data)) {
                return "{".implode(",", $data)."}";
            } else {
                return '{'.$data.'}';
            }
        } else {
            return '{}';
        }
    }

    public static function pg_array_to_php_array($data) {
        $data = preg_replace('/^\{(.*)\}$/', '$1', $data);
        if ($data === '') {
            return [];
        } else {
            $result = explode(',', $data);
            foreach ($result as &$value) {
                $value = preg_replace('/^\"(.*)\"$/', '$1', $value);
            }
            return $result;
        }
    }
}