<?php
if (count($argv) > 1) {
    $_SERVER = [
        'DOCUMENT_ROOT' => 
            realpath(__DIR__.DIRECTORY_SEPARATOR.'..')];
}
require_once(__DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'AutoLoader.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'AutoLoader.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'initialize.php');

if (empty($argv)) {
    $app = new ExampleApp();
    $app->http_main();

} else {
    if (count($argv) > 1) {
        $className = $argv[1];
        print(Environment::instance()->getMode().':'.$className."\n");
        array_shift($argv);
        array_shift($argv);
        $object = new $className($_SERVER, $argv);
        $object->execute();
    } else {
        echo 'php index.php <BatchClassName> [option ...]'."\n";
    }
}
