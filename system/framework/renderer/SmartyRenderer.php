<?php

class SmartyRenderer extends Renderer {
    public function __construct($model, $templateFileName, $isMobile) {
        $templateDir = 
            $model->getOption('documentRoot').DIRECTORY_SEPARATOR.
            'templates'.DIRECTORY_SEPARATOR.
            'common2'.DIRECTORY_SEPARATOR;
        parent::__construct(
            $templateDir,
            $templateFileName,
            $isMobile);
    }

    public function render($model) {
        $templateDir = 
            $model->getOption('documentRoot').DIRECTORY_SEPARATOR.
            'templates'.DIRECTORY_SEPARATOR.
            'common2'.DIRECTORY_SEPARATOR;
        $documentRoot = $model->getOption('documentRoot');
        $current = mb_internal_encoding();
        mb_internal_encoding('CP51932');
        $values = StringUtil::convertRecursion('CP51932', 'utf-8', $model->getValues());
        $smarty = new Smarty();
        $smarty->template_dir = $templateDir;
        $smarty->compile_dir  = $documentRoot.DIRECTORY_SEPARATOR.'templates_c'.DIRECTORY_SEPARATOR.'common2'.DIRECTORY_SEPARATOR;
        $smarty->config_dir   = $documentRoot.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR;
        $smarty->cache_dir    = $documentRoot.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;
        foreach ($values as $key => $value) {
            $smarty->assign($key, $value);
        }
        header("Content-Type: text/html;charset=euc-jp");
        $smarty->display($this->templateFileName);
        mb_internal_encoding($current);
    }
}