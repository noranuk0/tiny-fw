<?php

class IndexController extends Controller {
    public function createModel() {
        $this->model->putValue(
            'regions', 
            AreaService::instance()->getRegions());
        return 'index';
    }

    public function getDefaultRenderer() {
        return 'twig';
    }
}

