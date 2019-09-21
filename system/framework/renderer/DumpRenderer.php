<?php

class DumpRenderer extends Renderer {
    public function __construct($model, $templateFileName, $isMobile) {
        parent::__construct(
            null, null, $isMobile);
    }

    public function render($model) {
        $options = $model->getOptions();
        $options = StringUtil::escapeHtmlSpecialChars('UTF-8', $options);
        print('options:');
        dump($options);
        $values = $model->getValues();
        $values = StringUtil::escapeHtmlSpecialChars('UTF-8', $values);
        print('values:');
        dump($values);
    }
}