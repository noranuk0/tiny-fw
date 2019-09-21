<?php

abstract class App {
    
    public function __construct() {
    }

    protected function handlePageNotFound() {
        header("HTTP/1.1 404 Not Found");
        print('<h1>404 Page Not Found.</h1>');
    }

    protected function handleException($e) {
        header("HTTP/1.1 500 Internal Server Error");
        print('<h1>500 Internal server error.</h1>');
        if (Environment::instance()->getMode() !== 'production' ||
            !empty($requestParams['force_display_error'])) {
            print($e->getMessage()."<br/>\n");
            print($e->getTraceAsString()."<br/>\n");
            if (!empty($this->server)) {
                dump($this->server);
            }
            if (!empty($model)) {
                dump($model);
            }
        }
    }

    protected abstract function getRouter();

    public function http_main() {
        header('Content-Type: text/html; charset=UTF-8');

       try {
            if (NEED_BASIC_AUTH) {
                http_basic_authenticate_with(AUTH_USER, AUTH_PASSWORD);
            }
            $this->server = $_SERVER;
            $requestParams = [];
            if ($this->server['REQUEST_METHOD'] === 'GET') {
                $requestParams = $_GET;
            } else if ($this->server['REQUEST_METHOD'] === 'POST') {
                $requestParams = $_POST;
            }
            if (!empty($_FILES)) {
                $requestParams['_FILES'] = $_FILES;
            }
            if (!empty($_COOKIE)) {
                $requestParams['_COOKIE'] = $_COOKIE;
            }
            
            $u = explode('?', $this->server['REQUEST_URI']);
            $path = urldecode($u[0]);
            $contextRoot = CONTEXT_ROOT;
            $model = Environment::instance()->createModelObject();
            Interceptor::interceptorInitialize($model);
            Controller::controllerInitialize(Environment::instance()->isSmartPhone());
            $controller = 
                $this->getRouter()->routing(
                    $this->server['REQUEST_METHOD'], $path, $requestParams, $model);
            if ($controller != null) {
                Interceptor::invokeBeforeCreateModel();
                $templateFileName = $controller->createModel();
                Interceptor::invokeAfterCreateModel();
                
                if (!empty($requestParams['template'])) {
                    $templateFileName = $requestParams['template'];
                }
                $model->putOption("templateFileName", $templateFileName);
                $renderer = 
                    Renderer::create(
                        $model,
                        $templateFileName, 
                        !empty($requestParams['renderer']) ? 
                            $requestParams['renderer'] : 
                            $controller->getDefaultRenderer(),
                        Environment::instance()->isSmartPhone());
                if ($renderer != null) {
                    header("HTTP/1.1 200 OK");

                    Interceptor::invokeBeforeRenderer();
                    $renderer->render($model);
                } else {
                    throw new PageNotFoundException();
                }
            } else {
                throw new PageNotFoundException();
            }
        } catch (PageNotFoundException $e) {
            $this->handlePageNotFound();
        } catch (Exception $e) {
            $this->handleException($e);
        }
        return true;
    }
}