<?php

abstract class Resource {
    private static $resource = null;
    public static function initialize($documentRoot) {
        $fileName = 
            $documentRoot.DIRECTORY_SEPARATOR.
            'exe'.DIRECTORY_SEPARATOR.
            'assets'.DIRECTORY_SEPARATOR.
            'json'.DIRECTORY_SEPARATOR.
            'resource.json';

        if (file_exists ($fileName)) {
            $json = file_get_contents($fileName);
            $json = json_decode($json, true);
            Resource::$resource = $json;
        } else {
            Resource::$resource = [];
        }
    }

    public static function get($category, $value) {
        if (isset(Resource::$resource[$category]) && 
            isset(Resource::$resource[$category][$value])) {
            return Resource::$resource[$category][$value];
        } else {
            return null;
        }
    }
}
