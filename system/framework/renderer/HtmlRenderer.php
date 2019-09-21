<?php

class HtmlRenderer extends Renderer {

    public function __construct($model, $templateFileName, $isMobile) {
        parent::__construct(
            $model->getOption('documentRoot').DIRECTORY_SEPARATOR,
            $templateFileName,
            $isMobile);
    }

    public function render($model) {
        readfile($this->templateFileName);
    }
}