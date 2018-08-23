<?php
namespace app\services;


class CacheService{

    /**
     * @param $key
     * @param int $timeout
     * @return mixed
     */
    public static function getCache($key){
        $data = \Yii::$app->cache->get($key);
        return $data;
    }

    /**
     * @param $key
     * @param $value
     * @param int $timeout
     * @return bool
     */
    public static function setCache($key, $value, $timeout = 360000){
        return \Yii::$app->cache->set($key, $value, $timeout);
    }

}