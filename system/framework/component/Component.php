<?php

abstract class Component {
    public function __construct() {
    }

    protected abstract function create(&$componentModel, $renderer);

    public function render($renderer='twig') {
        $componentModel = 
            Environment::instance()->createModelObject();
        if ($this->create($componentModel, $renderer)) {
            $templateFileName = 
                'component'.DIRECTORY_SEPARATOR.underscore(get_class($this));
            $renderer = 
                Renderer::create(
                    $componentModel, 
                    $templateFileName, 
                    $renderer, 
                    Environment::instance()->isSmartPhone());
            $renderer->render($componentModel);
        }
    }
}
