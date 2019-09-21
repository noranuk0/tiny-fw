<?php

class TwigRenderer  extends Renderer {
    public function __construct($model, $templateFileName, $isMobile) {
        $templateDir = 
            $model->getOption('documentRoot').
            $model->getOption('systemRoot').DIRECTORY_SEPARATOR.
                'system'.DIRECTORY_SEPARATOR.
                'templates'.DIRECTORY_SEPARATOR.
                'twig'.DIRECTORY_SEPARATOR;
        parent::__construct(
            $templateDir,
            $templateFileName,
            $isMobile);
    }

    public function render($model) {
        $templateDir = 
            $model->getOption('documentRoot').
            $model->getOption('systemRoot').DIRECTORY_SEPARATOR.
                'system'.DIRECTORY_SEPARATOR.
                'templates'.DIRECTORY_SEPARATOR.
                'twig'.DIRECTORY_SEPARATOR;
        $loader = new Twig_Loader_Filesystem($templateDir);
        $isDebug = $model->getOption('environment') !== 'production';
        $twig = new Twig_Environment($loader, ['debug' => $isDebug]);

        $twigCustomFilter = new TwigCustomFilter();
        $customFilterList = $twigCustomFilter->getCustomFilterList();
        foreach ($customFilterList as $filterName => $filter) {
            $filter = new Twig_SimpleFilter($filterName, [$twigCustomFilter, $filter['name']], $filter['args']);
            $twig->addFilter($filter);
        }

        $twigCustomFunction = new TwigCustomFunction();
        $customFunctionList = $twigCustomFunction->getCustomFunctionList();
        foreach ($customFunctionList as $twigFunctionName => $function) {
            $function = new Twig_SimpleFunction($twigFunctionName, [$twigCustomFunction, $function['name']], $function['args']);
            $twig->addFunction($function);
        }

        $template = $twig->loadTemplate($this->templateFileName);
        $template->display($model->getValues());
    }
}