<?php

abstract class Router {
    protected function url_to_array($url) {
        if ($url !== '' &&
            strpos($url, '/') !== 0) {
            return false;
        }

        if (substr($url, -1) === '/') {
            $url = substr($url, 0, -1);
        }
        if ($url === '') {
            return [];
        }
        return explode('/', $url);
    }

    protected function regexp_url_matcher(
        $inputUrl, $matchUrl) {
            if (preg_match('@^'.$matchUrl.'$@', $inputUrl)) {
                return true;
            } else {
                return false;
            }
    }

    protected function url_matcher(
        $inputUrlParts, $matchUrl, &$resultParams) {

        $matchUrlParts = $this->url_to_array($matchUrl);
        if ($inputUrlParts === false || 
            $matchUrlParts === false) {
        }

        $resultParams = [];
        if (count($inputUrlParts) !== count($matchUrlParts)) {
            return false;
        }

        for ($index = 1; $index < count($inputUrlParts); $index++) {
            if ($inputUrlParts[$index] === '') {
                return false;
            }
            $path = 
                preg_replace(
                    '/^\{([^}]+)\}$/', '\1', $matchUrlParts[$index], 1, $replacedCount);
            if ($replacedCount === 0) {
                if ($inputUrlParts[$index] !== $matchUrlParts[$index]) {
                    // パスが一致しない
                    return false;
                }
            } else if ($replacedCount === 1) {
                if ($path === '') {
                    return false;
                }
                if (isset($pathParams[$index])) {
                    // パス変数の重複
                    return false;
                } else {
                    $regexpPath = explode(':', $path);
                    if (count($regexpPath) === 1) {
                        // パス変数の設定
                        $resultParams[$path] = $inputUrlParts[$index];
                    } else if (count($regexpPath) === 2) {
                        if (preg_match('/^'.$regexpPath[1].'$/', $inputUrlParts[$index])) {
                            $resultParams[$regexpPath[0]] = $inputUrlParts[$index];
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
        return true;
    }

    protected function injectComponent($model, $name, $component) {
        $model->putValue($name, $component->create());
    }

    public abstract function routing(
        $method, $url, $requestParams,
        $model);
}