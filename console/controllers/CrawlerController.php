<?php
namespace console\controllers;

use common\models\Crawlerarticlelistpage;

class CrawlerController extends \yii\console\Controller{
    /**
     * yii crawler/go
     * 自动生成数据库的MODEL层
     */
    public function actionGo(){
        while (true){
            try{
                $aryListpage = Crawlerarticlelistpage::find()->where([
                    //'process_id' => 0,
                    'is_normal' => 1,
                    'enable' => 1
                ])->andWhere(time().'>starttime and endtime > '.time().' and  start_working_time_last_time < ' . (time() - 300))->all();

                foreach ($aryListpage as $one) {
                    \app\services\CrawlerService::crawl($one);
                }
            }catch (\Throwable $throwable){
                $this->actionGo();
            }
        }
    }


}