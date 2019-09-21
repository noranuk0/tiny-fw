<?php

class PostSearchController extends Controller {
    protected $regionId;

    public function __construct($model, $requestParams) {
        parent::__construct($model);
        $this->regionId = empty($requestParams['region']) ? null : $requestParams['region'];
    }

    public function createModel() {
        if (empty($this->regionId)) {
            $this->redirect('/error');
        }
        $this->redirect('/search?region='.$this->regionId);
        return null;
    }


    public function getDefaultRenderer() {
        return 'null';
    }
}