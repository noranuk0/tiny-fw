<?php

abstract class Interceptor {
    public static $interceptors = [];
    protected static $model = null;

    public static function interceptorInitialize(&$model) {
        Interceptor::$model = $model;
    }

    public static function add($interceptor) {
        Interceptor::$interceptors []= $interceptor;
    }

    public static function invokeBeforeCreateModel() {
        foreach(Interceptor::$interceptors as $interceptor) {
            $interceptor->beforeCreateModel();
        }
    }

    public static function invokeAfterCreateModel() {
        foreach(Interceptor::$interceptors as $interceptor) {
            $interceptor->afterCreateModel();
        }
    }

    public static function invokeBeforeRenderer() {
        foreach(Interceptor::$interceptors as $interceptor) {
            $interceptor->beforeRenderer();
        }
    }

    public function __construct() {
    }

    public function beforeCreateModel() {
    }

    public function afterCreateModel() {
    }

    public function beforeRenderer() {
    }
}