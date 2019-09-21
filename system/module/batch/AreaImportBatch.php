<?php

class AreaImportBatch extends Batch {
    public function execute() {
        $file = new SplFileObject(
            __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'region.csv'); 
        $file->setFlags(SplFileObject::READ_CSV); 
        foreach ($file as $line) {
            if(count($line) > 1) {
                DataService::instance()->insert(
                    'area.m_regions', [
                        'region_id' => intval($line[0]),
                        'name' => $line[1]
                    ]);
            }
        }
        
        $file = new SplFileObject(
            __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'prefecture.csv'); 
        $file->setFlags(SplFileObject::READ_CSV); 
        foreach ($file as $line) {
            if(count($line) > 3) {
                DataService::instance()->insert(
                    'area.m_prefectures', [
                        'region_id' => intval($line[1]),
                        'prefecture_id' => intval($line[0]),
                        'name' => $line[3]
                    ]);
            }
        }
    }
}
