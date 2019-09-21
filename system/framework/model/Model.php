<?php

class Model {
    private $values = [];
    private $extendOptions = [];

    public function putValues($values) {
        if (!empty($values) && is_array($values)) {
            $this->values = array_merge($this->values, $values);
        }
    }
    
    public function putValue($key, $value) {
        $this->values [$key] = $value;
    }

    public function putOption($key, $value) {
        $this->extendOptions[$key] = $value;
    }

    public function getOption($key) {
        if (isset($this->extendOptions[$key])) {
            return $this->extendOptions[$key];
        } else {
            return null;
        }
    }

    public function getValues() {
        return $this->values;
    }

    public function getOptions() {
        return $this->extendOptions;
    }

    public function getValue($key) {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        } else {
            return null;
        }
    }
}