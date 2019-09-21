<?php

function http_basic_authenticate_with($name,$password,$realm = "Protected area"){
    if (!isset($_SERVER['PHP_AUTH_USER']) || !($_SERVER['PHP_AUTH_USER'] == $name && $_SERVER['PHP_AUTH_PW'] == $password )) {
      header('WWW-Authenticate: Basic realm="'.$realm.'"');
      header('HTTP/1.0 401 Unauthorized');
      echo 'Not allowed to access.';
      exit;
    }
}

function dump($value) {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

function starts_with($haystack, $needle) {
    return (strpos($haystack, $needle) === 0);
}

function ends_with($haystack, $needle) {
    return (strlen($haystack) > strlen($needle)) ? (substr($haystack, -strlen($needle)) == $needle) : false;
}

function underscore($str) {
    return ltrim(strtolower(preg_replace('/[A-Z]/', '_\0', $str)), '_');
}

function camelize($str) {
    return lcfirst(strtr(ucwords(strtr($str, ['_' => ' '])), [' ' => '']));
}