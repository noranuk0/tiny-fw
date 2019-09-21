<?php

class MySqlUtil {
    protected function mysql_bit1_to_boolean($input) {
        return ord(strval($input)) != 0;
    }
}