<?php

abstract class Controller {
    protected $model = null;

    public function __construct($model) {
        $this->model = $model;
    }

    public static function controllerInitialize() {
    }

    protected function loadStaticFiles($names) {
        $result = [];
        foreach($names as $name) {
            $result[$name] = $this->loadStaticFile($name);
        }
        return $result;
    }

    protected function loadStaticFile($name) {
        if (file_exists($this->model->getOption('documentRoot').DIRECTORY_SEPARATOR.
            $this->site.'_html'.DIRECTORY_SEPARATOR.'static_html_parts'.DIRECTORY_SEPARATOR.
            $name.'.html')) {
            return 
                file_get_contents(
                    $this->model->getOption('documentRoot').DIRECTORY_SEPARATOR.
                    $this->site.'_html'.DIRECTORY_SEPARATOR.'static_html_parts'.DIRECTORY_SEPARATOR.
                    $name.'.html');
        } else {
            return '';
        }
    }

    protected function redirect($url) {
        header( "HTTP/1.1 301 Moved Permanently" );
        header('Location: '.$url);
        exit;
    }

    public function createModel() {
        return null;
    }

    abstract public function getDefaultRenderer();
}
