<?php

class DefaultPostController extends Controller {
    public function __construct($model, $requestParams) {
        $this->model = $model;
        $this->model->putValue('form', $requestParams);
    }

    public function getDefaultRenderer() {
        return 'json';
    }
}