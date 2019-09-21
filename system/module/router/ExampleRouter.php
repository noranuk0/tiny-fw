<?php

class ExampleRouter extends Router {
    public function routing(
        $method, $url, $requestParams,
        $model) {

        $contextRoot = $model->getOption('contextRoot');
        $documentRoot = $model->getOption('documentRoot');

        if (strlen($url) > 0 && strpos($url, '/') !== 0) {
            return false;
        }
        $pathValues = null;
        $controller = null;
        $inputUrlParts = $this->url_to_array($url);
        if ($method === 'GET') {
            if ($this->url_matcher($inputUrlParts, '/', $pathValues)) {
                $controller = new IndexController($model);
            } else if ($this->url_matcher($inputUrlParts, '/search', $pathValues)) {
                $controller = new SearchController($model, $requestParams);
            }
        } else if ($method == 'POST') {
            if ($this->url_matcher($inputUrlParts, '/search', $pathValues)) {
                $controller = new PostSearchController($model, $requestParams);
            }
        }
        return $controller;
    }
}