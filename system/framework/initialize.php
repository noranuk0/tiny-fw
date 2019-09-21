<?php

if (!isset($_SERVER)) {
    print ('$_SERVER not defined.'."\n");
    exit;
}

ini_set('display_errors', 1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
ini_set('xdebug.var_display_max_depth', -1);
date_default_timezone_set('Asia/Tokyo');
setlocale(LC_ALL, 'ja_JP.utf8');
mb_internal_encoding('utf-8');
mb_regex_encoding('utf-8');

require_once(__DIR__.DIRECTORY_SEPARATOR.'global.php');

Environment::initializeEnvironment($_SERVER);
$mode = Environment::instance()->getMode();
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.
    'configs'.DIRECTORY_SEPARATOR.'config.'.$mode.'.php');
Service::serviceInitialize(
    Environment::instance()->openDatabaseConnection());
ini_set('display_errors', $mode !== 'production');


