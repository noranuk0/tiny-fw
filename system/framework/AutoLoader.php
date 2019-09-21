<?php
class AutoLoader {
    protected $dirs;

    public function __construct() {
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'app');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'batch');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'component');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'controller');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'env');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'exception');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'interceptor');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'model');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'renderer');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'router');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'service');
        $this->registerDir(__DIR__.DIRECTORY_SEPARATOR.'util');
        $this->register();
    }

    private function register() {
        spl_autoload_register([$this, 'autoLoad']);
    }

    public function registerDir($dir) {
        $children = glob($dir.'/*', GLOB_ONLYDIR);
        foreach ($children as $child) {
            $this->dirs []= $child;
        }
        $this->dirs []= $dir;
    }

    public function autoLoad($className) {
        foreach ($this->dirs as $dir) {
            $file = $dir . '/' . $className . '.php';
            if (is_readable($file)) {
                require $file;
                break;
            }
        }
    }
}

new AutoLoader();