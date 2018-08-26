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

        $articles = Crawlerarticle::find()->limit(20)
            ->orderBy('article_time desc')->select('id,title,article_time')->all();
        $string = $this->render('index',[
            'articles' => $articles
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
            'content_type' => $content_type,
            'type' =>  \common\models\Crawlercontenttype::findOne($content_type)
        ]);
    }

    public function actionAjaxList(){
        $content_type = intval($this->getParam('content_type'));
        $offset = intval($this->getParam('offset'));
        $q = Crawlerarticle::find();
        if($content_type){
            $q->where('content_type=' . $content_type);
        }
        $articles = $q->offset($offset)->limit(20)
            ->orderBy('article_time desc')->select('id,title,article_time')->all();
        return $this->jsonSuccess($articles);
    }

}