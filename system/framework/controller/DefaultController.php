<?php


class DefaultController extends Controller {

    private $templateFileName;
    private $url;
    private $pathValue;
    private $requestParams;
    private $modelValues;
    private $staticTemplates;
    private $defaultRenderer;

    public function __construct(
        $model,
        $url, $templateFileName, $pathValue, $requestParams, $modelValues, $staticTemplates, $defaultRenderer) {
        parent::__construct($model);

        $this->url = $url;
        $this->templateFileName = $templateFileName;
        $this->requestParams = $requestParams;
        $this->pathValue = $pathValue;
        $this->modelValues = $modelValues;
        $this->staticTemplates = $staticTemplates;
        $this->defaultRenderer = $defaultRenderer;
    }

    public function createModel() {
        parent::createModel();
        if ($this->staticTemplates) {
            $this->model->putValue('static', $this->loadAreaCodes($this->staticTemplates));
        }
        $this->model->putValue('url', $this->url);
        $this->model->putValues($this->pathValue);
        $this->model->putValues($this->requestParams);
        $this->model->putValues($this->modelValues);
        return 
            $this->templateFileName;
    }

    public function getDefaultRenderer() {
        return $this->defaultRenderer;
    }
}
