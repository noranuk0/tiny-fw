<?php

class FormController extends Controller {
    public const MODE_INPUT = 'input';
    public const MODE_CONFIRM = 'confirm';
    public const MODE_COMPLETE = 'complete';

    protected $method;
    protected $mode;
    protected $postParams;

    public function __construct($model, $method, $requestParams, $key = 'data') {
        parent::__construct($model);
        $this->method = $method;
        $this->mode = empty($requestParams['mode']) ? 'input' : $requestParams['mode'];
        if ($method === 'POST') {
            $this->postParams = $requestParams[$key];
        }
    }

    public function createModel() {
        if ($this->method === 'GET') {
            if ($this->mode === self::MODE_INPUT) {
                return $this->createModelInput();
            }
        } else if ($this->method == 'POST') {
            if ($this->mode === self::MODE_INPUT) {
                return $this->createModelInput();
            } else if ($this->mode === self::MODE_CONFIRM) {
                return $this->postConfirm();
            } else if ($this->mode == self::MODE_COMPLETE) {
                return $this->postComplete();
            }
        }

    }

    protected function createModelInput(){}
    protected function postConfirm(){}
    protected function postComplete(){}

    public function getDefaultRenderer() {
        return 'twig';
    }
}