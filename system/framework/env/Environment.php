<?php

class Environment {
    private static $instance = null;

    private $mode;
    private $server;

    public static function instance() {
        return Environment::$instance;
    }

    private static function loadSystemEnvironmentMode() {
        $fileName = 
            __DIR__.DIRECTORY_SEPARATOR.
            '..'.DIRECTORY_SEPARATOR.
            '..'.DIRECTORY_SEPARATOR.
            'configs'.DIRECTORY_SEPARATOR.
            '.environment';
        if (!file_exists($fileName)) {
            $mode = 'development';
        } else {
            $mode = trim(
                file_get_contents(
                    $fileName));
            if (empty($mode)) {
                $mode = 'development';
            }
        }
        return $mode;
    }

    public function getMode() {
        return $this->mode;
    }

    public static function initializeEnvironment($server) {
        if (Environment::$instance === null) {
            Environment::$instance = 
                new Environment(Environment::loadSystemEnvironmentMode(), $server);
        }
        return Environment::instance();
    }

    private function __construct($mode, $server) {
        $this->mode = $mode;
        $this->server = $server;
    }

    public function isSmartPhone() {
        $ua = $this->server['HTTP_USER_AGENT'];
        if ( $ua != null &&
            preg_match('/iPhone|iPod|Android|Mobile/i', $ua) ) {
            return true;
        } else {
            return false;
        }
    }

    public function createModelObject() {
        $model = new Model();
        $documentRoot = realpath(rtrim($this->server['DOCUMENT_ROOT'], '/'));
        $systemRoot = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
        $systemRoot = substr($systemRoot, strlen($documentRoot));
        $model->putOption('documentRoot', $documentRoot);
        $model->putOption('systemRoot', $systemRoot);
        $model->putOption('protocol', empty($this->server['HTTPS']) ? 'http://' : 'https://');
        $model->putOption('host', empty($this->server['HTTP_HOST']) ? '' : $this->server['HTTP_HOST']);
        $model->putOption('remote_address', empty($this->server['REMOTE_ADDR']) ? '' : $this->server['REMOTE_ADDR']);
        $model->putOption('user_agent', !empty($this->server['HTTP_USER_AGENT']) ? $this->server['HTTP_USER_AGENT'] : '');
        $model->putOption('referer', !empty($this->server['HTTP_REFERER']) ? $this->server['HTTP_REFERER'] : '');
        
        $model->putOption('contextRoot', CONTEXT_ROOT);
        $model->putOption('environment', $this->mode);
        return $model;
    }
    
    public function openDatabaseConnection() {
        $db = null;
        if (!empty(PDO_DRIVER_SYS)) {
            $DbDSN = PDO_DRIVER_SYS.":host=".DB_HOST_SYS.";dbname=".DB_DATABASE_SYS; //.";charset=utf8";
            $DbUser = DB_USERNAME_SYS;
            $DbPassword = DB_PASSWORD_SYS;
            
            try {
                $db = new PDO(
                    $DbDSN, 
                    $DbUser, 
                    $DbPassword);
                $db->setAttribute(
                    PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            } catch (Exception $e) {
                $db = null;
                throw $e;
            }
        }
        return $db;
    }
}