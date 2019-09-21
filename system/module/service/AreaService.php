<?php

class AreaService extends Service {
    private static $instance;

    public static function instance() {
        if (AreaService::$instance == null) {
            AreaService::$instance = new AreaService();
        }
        return AreaService::$instance;
    }

    public function getRegions() {
        return DataService::instance()->all('area.m_regions', 'region_id');
    }
    public function getRegion($regionId) {
        return DataService::instance()->find(
            'area.m_regions', 
            'region_id = :region_id', 
            [':region_id' => $regionId]);
    }
    public function getPrefectures($regionId) {
        return DataService::instance()->findAll(
            'area.m_prefectures', 
            'region_id = :region_id', 
            [':region_id' => $regionId],
            'prefecture_id');
    }
}