<?php

class SearchController extends Controller {
    protected $regionId;

    public function __construct($model, $requestParams) {
        parent::__construct($model);
        $this->regionId = empty($requestParams['region']) ? null : $requestParams['region'];
    }

    public function createModel() {
        if (empty($this->regionId)) {
            $this->redirect('/');
        }

        $region = AreaService::instance()->getRegion($this->regionId);
        if (empty($region)) {
            throw new PageNotFoundException();
        }
        $this->model->putValue(
            'region', $region);

        $this->model->putValue(
            'prefectures', 
            AreaService::instance()->getPrefectures($this->regionId));

        return 'search';
    }

    public function getDefaultRenderer() {
        return 'twig';
    }
}