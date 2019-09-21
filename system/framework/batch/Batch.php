<?php

abstract class Batch {
    protected $server;
    protected $params;

    public function __construct($server, $params) {
        $this->server = $server;
        $this->params = $params;
        Service::serviceInitialize(
            Environment::instance()->openDatabaseConnection());
    }

    public abstract function execute();
}