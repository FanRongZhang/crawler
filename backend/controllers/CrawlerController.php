<?php
namespace backend\controllers;

use app\services\CrawlerService;
use app\services\HtmlFormatService;
use app\services\MsgcodeService;
use app\services\UrlQueryService;
use common\models\Articlecategory;
use common\models\Book;
use common\models\Crawlerarticle;
use common\models\Crawlerarticlelistpage;
use common\models\Crawlerdomain;
use common\models\Exam;
use QL\QueryList;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class CrawlerController extends BasewebController{


    public function actionDomains(){
        $data = $this->getPageData(Crawlerdomain::find()->orderBy('id desc'),$this->page);
        return $this->render('domains',$data);
    }


    public function actionCreatedomain(){
        if($this->request->isGet){
            return $this->render('createdomain');
        }else{
            $domain = new Crawlerdomain();
            $domain->setAttributes($this->param,false);
            $domain->createtime = date('Y-m-d H:i:s');
            $domainInDB = Crawlerdomain::find()->where([
                'domain' => $domain->domain
            ])->one();
            if($domainInDB){
                $this->addAlertInfo('该域名已经存在了');
                return $this->redirect(Url::current());
            }else{
                if($domain->save()){
                    return $this->redirect('domains');
                }else{
                    throw new Exception(json_encode($domain->getFirstErrors()));
                }
            }
        }
    }


    public function actionEditdomain(){
        $domain = Crawlerdomain::findOne($this->getParam('id'));
        if($this->request->isGet){
            return $this->render('editdomain',[
                'domain' => $domain
            ]);
        }else{
            $domain->setAttributes($this->param,false);
            $domain->createtime = date('Y-m-d H:i:s');

            if($domain->save()){
                $this->addAlertInfo('操作成功');
                return $this->redirect('domains');
            }else{
                throw new Exception(json_encode($domain->getFirstErrors()));
            }
        }
    }

    public function actionCreatelistpage(){
        if($this->request->isGet){
            $exam = false;
            if( $examid = $this->getParam('examid') ){
                $exam = Exam::findOne($examid);
            }
            $domainid = $this->getParam('domainid');
            $exams = Exam::find()->orderBy('area desc,year desc')->all();
            if($domainid) {
                $domain = Crawlerdomain::findOne($domainid);
            }else{
                $domain = Crawlerdomain::find()->orderBy('id desc')->limit(1)->one();
            }
            return $this->render('createlistpage',[
                'aryParam' => $this->param,
                'domains' => Crawlerdomain::find()->all(),
                'domainid' => $domainid,
                'domain' => $domain,
                'categories' => Articlecategory::find()->all(),
                'exams' => $exams,
                'exam' => $exam,
                'lastexamid' => isset($_SESSION['actionCreatelistpage_lastexamid']) ? $_SESSION['actionCreatelistpage_lastexamid'] : '',
            ]);
        }else{
            set_time_limit(0);
            $listpage = new Crawlerarticlelistpage();
            $listpage->setAttributes($this->param,false);
            $listpage->is_normal = 1;
            $listpage->starttime = strtotime($listpage->starttime);
            $listpage->endtime = strtotime($listpage->endtime);
            $listpage->start_working_time_last_time =0;
            $listpage->end_working_time_last_time = 0;
            $listpageInDB = Crawlerarticlelistpage::find()->where([
                'url' => $listpage->url
            ])->one();
            if($listpageInDB){
                $this->addAlertInfo('该列表页已经存在了');
                return $this->redirect(Url::current());
            }else{
                if($listpage->save()){

                    $_SESSION['actionCreatelistpage_lastexamid'] = $listpage->examid;
                    $processesCount = CrawlerService::PROCESSES_COUNT;
                    if($listpage->id <= $processesCount){
                        $listpage->process_id = ($listpage->id - 1);
                    }else{
                        $listpage->process_id = $listpage->id % $processesCount;
                    }
                    $listpage->save();

                    if($this->getParam('lianxuyema') == 1){
                        $this->lianxuyema($listpage, $this->getParam('yemadizhi'), $this->getParam('qishiyema'), $this->getParam('jiesuyema'));
                    }
                    $this->addAlertInfo('操作成功');
                    return $this->redirect(Url::current());
                }else{
                    throw new Exception(json_encode($listpage->getFirstErrors()));
                }
            }
        }
    }

    private function lianxuyema(Crawlerarticlelistpage $listpage, $url, $qishi, $jiesu){
        while ($qishi <= $jiesu){
            $newListpage = new Crawlerarticlelistpage();
            $newListpage->setAttributes($listpage->getAttributes(null,[
                'id'
            ]),false);
            $newListpage->url = str_replace('{page}',$qishi, $url);
            $newListpage->is_normal = 1;
            $newListpage->save();
            $processesCount = CrawlerService::PROCESSES_COUNT;
            if($newListpage->id <= $processesCount){
                $newListpage->process_id = ($newListpage->id - 1);
            }else{
                $newListpage->process_id = $newListpage->id % $processesCount;
            }
            $newListpage->save();
            $qishi++;
        }
    }


    public function actionEditlistpage(){
        $listpage = Crawlerarticlelistpage::findOne($this->getParam('id'));
        if($this->request->isGet){
            $exams = Exam::find()->orderBy('area desc,year desc')->all();
            return $this->render('editlistpage',[
                'domains' => Crawlerdomain::find()->all(),
                'categories' => Articlecategory::find()->all(),
                'exams' => $exams,
                'crawlerlistpage' => $listpage
            ]);
        }else{
            $listpage->setAttributes($this->param,false);
            $listpage->starttime = strtotime($listpage->starttime);
            $listpage->endtime = strtotime($listpage->endtime);
            $listpageInDB = Crawlerarticlelistpage::find()->where([
                'url' => $listpage->url
            ])->andWhere('id != '.$listpage->id)->one();
            if($listpageInDB){
                $this->addAlertInfo('该列表页已经存在了');
                return $this->redirect(Url::current());
            }else{
                if($listpage->save()){
                    $this->addAlertInfo('操作成功');
                    return $this->redirect(Url::current());
                }else{
                    throw new Exception(json_encode($listpage->getFirstErrors()));
                }
            }
        }
    }


    public function actionIndex(){
        $exam = false;
        $query = Crawlerarticlelistpage::find()->orderBy('domainid desc,id desc')->where('1=1');
        if( $examid = $this->getParam('examid') ){
            $exam = Exam::findOne($examid);
            $query->andWhere([
                'examid' => $examid
            ]);
        }

        if( $is_normal = $this->getParam('is_normal') ){
            $query->andWhere([
                'is_normal' => $is_normal
            ]);
        }
        $data = $this->getPageData( $query , $this->page);
        return $this->render('index', ArrayHelper::merge($data,[
            'exam' => $exam
        ]));
    }

    public function actionArticle(){
        $exam = false;
        $q = Crawlerarticle::find()->where([
            'is_deleted' => 0,
            'hadhandle' => 0
        ]);//->orderBy('id desc');
        if($examid = $this->getParam('examid')){
            $exam = Exam::findOne($examid);
            $q->andWhere('listpageid in (select id from crawlerarticlelistpage where examid='.$examid.')');
        }
        $data = $this->getPageData($q,$this->page);
        return $this->render('article', ArrayHelper::merge($data,[
            'exam' => $exam
        ]));
    }

    public function actionDeletearticle(){
        $article = Crawlerarticle::findOne($this->getParam('id'));
        $article->is_deleted = 1;
        if($article->save()){
            exit('删除成功');
        }else{
            exit('删除失败');
        }
    }

    public function actionShowarticle(){
        return $this->render('showarticle',[
            'showarticle' => Crawlerarticle::findOne($this->getParam('id'))
        ]);
    }

    public function actionTest()
    {
        $this->layout = false;
        //url:'/crawler/test?url='+$('#url').val()+'&xpath_a='+$('#xpath_a').val()+'&xpath_content='+$('#xpath_content').val()+'&xpath_content_path='+$('#xpath_content_path').val()+'&r='+Math.random(),
        $listpage = new Crawlerarticlelistpage();
        $listpage->setAttributes($this->param, false);

        $testResult = $this->render('test', [
            'aryLinks' => CrawlerService::crawl($listpage, false)
        ]);
        return $testResult;
    }

    public function actionMarktonormal(){
        $id = $this->getParam('id');
        $listpage = Crawlerarticlelistpage::findOne($id);
        $listpage->is_normal = 1;
        $listpage->unnormal_system_mark = '';
        if($listpage->save()){
            return $this->jsonSuccess();
        }
        var_dump($listpage->getFirstErrors());
        exit;
    }

    public function actionUsethearticle(){
        $id = $this->getParam('id');
        $article = Crawlerarticle::findOne($id);
        $article->hadhandle = 1;
        if($article->save()){
            return $this->redirect('/publicnotice/add-new-record?fromcrawlerarticle=1&categoryid='.$article->articlecategory.'&articleid='.$article->id.'&listpageid='.$article->listpageid);
        }
        var_dump($article->getFirstErrors());
        exit;
    }

}