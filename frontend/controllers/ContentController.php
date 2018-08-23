<?php

namespace frontend\controllers;

use app\services\GenerateTableModelService;
use app\services\CacheService;
use app\services\SyncDBAndElasticSearchService;
use common\models\Articlecategory;
use common\models\Crawlerarticle;
use common\models\Exam;
use common\models\Examtype;
use common\models\Extofkaochagongshi;
use common\models\Extofmianshigonggao;
use common\models\Extofniluyonggongshi;
use common\models\Extofzhaokaogonggao;
use common\models\Extofzhigefushen;
use common\models\Extoticegonggao;
use common\models\Extotijiangonggao;
use common\models\Mianshichengjitable;
use common\models\Model;
use common\models\Areasection;
use common\models\Netcourse;
use common\models\Netcourseteacher;
use common\models\Publicnotice;
use common\models\Region;
use common\models\Department;
use common\models\Major;
use common\models\Position;
use common\models\Right_img;
use common\models\Sitesetting;
use app\services\ContentModelSearchService;
use yii\data\Pagination;
use yii\db\Query;
use yii;

class ContentController extends BasewebController{

    public function actionIndex(){
        $this->returnPageCacheIfExists();

        $string = $this->render('index',[

        ]);

        $this->makePageCache($string, 10);
        return $string;
    }

    public function actionArticle(){
        $article = Crawlerarticle::findOne(intval($this->getParam('id')));
        return $this->render('article',[
            'article' => $article
        ]);
    }

    public function actionList(){
        $content_type = intval($this->getParam('content_type'));
        return $this->render('list',[
            'content_type' => $content_type
        ]);
    }

    public function actionAjaxList(){
        $content_type = intval($this->getParam('content_type'));
        $offset = intval($this->getParam('offset'));
        $articles = Crawlerarticle::find()->where('content_type=' . $content_type)->offset($offset)->limit(20)
            ->orderBy('article_time desc')->select('id,title')->all();
        return $this->jsonSuccess($articles);
    }

    public function actionKaoshi(){
        $this->returnPageCacheIfExists();

        $this->layout = "base";
        $this->title = '公务员考试网_2018国家公务员考试网_国考公告报名时间/职位/成绩查询';
        $this->description = '【毕上教育】大数据智能系统为您提供国考、省考、事业单位、招教、银行、会计、国企、医疗等公职类考试实时公告推送、职位、成绩查询等。让科技为您的考试助力！';
        $this->keywords = '公务员,公务员考试网,国家公务员,国家公务员考试网,2018国家公务员考试网,2018省考';
        $bannerList = Right_img::find()->where(['category'=>682,'is_deleted'=>0])->orderBy('order desc,updated_at desc')->all();
        $recommend = Sitesetting::findOne(['name'=>'网站首页推荐位']);

        $string =  $this->render('kaoshi',[
            'area'=>CacheService::getAreaRelationCache(),
            'bannerList'=>$bannerList,
            'recommend'=>$recommend
        ]);

        $this->makePageCache($string);
        return $string;
    }


}