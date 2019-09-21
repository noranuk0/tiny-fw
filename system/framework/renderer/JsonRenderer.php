<?php

class JsonRenderer extends Renderer {
    public function __construct($model, $templateFileName, $isMobile) {
        parent::__construct(
            null, null, $isMobile);
    }

    public function render($model) {
        $values = $model->getValues();
        header( "HTTP/1.1 200 OK" );
        header('content-type: application/json; charset=utf-8');
        $json = json_encode($values);
        if ($json) {
            print($json);
        } else {
            print('{'.'"error_no":'.json_last_error().',"error_msg":"'.json_last_error_msg().'"}');
        }
    }
}