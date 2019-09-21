<?php

class TwigCustomFilter {
    private $customFilterList = [
        'ord' => ['name' => 'twig_ord', 'args' => []],
        'embed' => ['name' => 'twig_embed', 'args' => []],
        'debug' => ['name' => 'twig_debug', 'args' => ['needs_environment' => true]]
    ];
    public function getCustomFilterList() {
        return $this->customFilterList;
    }

    public function twig_ord($input) {
        if (!empty($input)) {
            return ord($input);
        } else {
            return 0;
        }
    }

    public function twig_embed($file) {
        if (!empty($_SERVER['DOCUMENT_ROOT']) && substr($file, 0, 1) != '/') {
            $file = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$file;
        }
        if (!empty($file) && 
            file_exists($file) && 
            is_file($file)) {
            return file_get_contents($file);
        } else {
            return '[file not found]'.$file;
        }
    }

    public function twig_debug($environment, $input) {
        return $environment->isDebug() ? $input : '';
    }
}