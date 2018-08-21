<?php
namespace backend\controllers;

use app\services\MsgcodeService;
use common\models\User;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\web\Controller;
use common\models\Adminuser;
use common\models\Roles;
use common\models\Rolerights;
use common\models\Access;
use common\models\Roleusers;


/**
 * 后台
 * Class IndexController
 * @package backend\controllers
 */
class BasewebController extends Controller
{

    public $bartitle;

    public $layout = 'main';

    protected $param;

    /**
     * 请求网页的第几页
     * @var integer
     */
    public $page;

    /**
     * @var \Yii::$app->request
     */
    protected $request;


    /**
     * @var \Yii::$app->response
     */
    protected $response;

    /**
     * @var Pagination
     */
    public $pagination;

    /**
     * 当前登录的用户
     * @var \common\models\Adminuser
     */
    public $user;

    public $userid;

    public function getHostInfo(){
        return $this->request->hostInfo;
    }

    /**
     * 返回ar[]数组和分页对象
     * @param ActiveQuery $query
     * @param number $page
     * @param number $pageSize
     * @param string $asArray
     * @return \yii\data\Pagination[]|array[]|\yii\db\ActiveRecord[][]
     */
    public function getPageData(ActiveQuery $query,$page=1,$pageSize=20,$asArray = false){
        $pagination= new Pagination([
            'totalCount' =>$query->count(),
            'pageSize' => $pageSize
        ]);
        $data = $query->offset(($page-1)*$pageSize)->limit($pagination->limit)->asArray($asArray)->all();
        $this->pagination = $pagination;
        return [
            'list'=>$data,
            'pages'=>$pagination
        ];
    }

    /**
     * @param string $id the ID of this controller.
     * @param Module $module the module that this controller belongs to.
     * @param array $config name-value pairs that will be used to initialize the object properties.
     */
    public function __construct($id, $module, $config = [])
    {

        \Yii::$app->name = '公务员';
        ini_set('upload_tmp_dir', \Yii::getAlias('@backend') . '/runtime/temp');

        //ini_set('session.gc_maxlifetime', 3600 * 60000);
        parent::__construct($id, $module, $config);

        $this->request = \Yii::$app->request;
        $this->response = \Yii::$app->response;

        if($this->request->getIsAjax()){
            $this->layout = false;
        }

        //all param name is lower
        $this->param = array_merge($this->request->get(),$this->request->post());
        foreach ($this->param as $k=>$v){
            $lower_key = strtolower($k);
            if($k!=$lower_key){
                unset($this->param[$k]);
                $this->param[$lower_key] = $v;
            }
        }

        $this->page = $this->getParam('page') ? intval($this->getParam('page')) : 1;

        $userID = \Yii::$app->getUser()->getId();
        if($userID) {
            $this->user = User::findOne($userID);
        }else{
            $this->user = null;
        }
    }


    /**
     * get request param value
     * @param string $name
     * @return boolean
     */
    public function getParam($name){
        $name = strtolower($name);
        if(!isset($this->param[$name])){
            return false;
        }
        return $this->param[$name];
    }

    /**
     * come back after login from wx
     * @param string $httpAbsoluteUrl  access url when come back
     */
    public function goToLogin(){
        exit('<script>location.href = \'/index/login\'</script>');
    }

    /**
     * need to have be login,or go to login
     */
    public function needToLogin(){
        if(!$this->user){
            $this->goToLogin();
        }
    }

    public function logout(){
        $session = \yii::$app->session;
        $session->remove('backenduser');
        $this->user = null;
    }

    public function return404(){
        return $this->renderPartial('/../404');
    }

    public function jsonSuccess($data=[]){
        $this->response->format = \yii\web\response::FORMAT_JSON;
        return [
            'code'=>MsgcodeService::OP_SUCCESS,
            'msg'=>MsgcodeService::getRetMsg(MsgcodeService::OP_SUCCESS),
            'data'=>$data
        ];
    }

    public function jsonFail($code=MsgcodeService::OP_FAILRE){
        $this->response->format = \yii\web\response::FORMAT_JSON;
        return [
            'code'=>$code,
            'msg'=>MsgcodeService::getRetMsg($code)
        ];
    }

    public function jsonPure(&$data){
        $this->response->format = \yii\web\response::FORMAT_JSON;
        return $data;
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is `true`.
        return parent::beforeAction($action);
    }

    /**
     * 添加提示信息
     * @param $msg
     */
    public function addAlertInfo($msg){
        \Yii::$app->session->addFlash('alert',$msg);
    }

    public function exportExcel($aryData, $fileName='simple.xls'){
        ini_set('max_execution_time', '0');
        $fileName=str_replace('.xls', '', $fileName).'.xls';
        $phpexcel = new \PHPExcel();
        $phpexcel->getProperties()
            ->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $phpexcel->getActiveSheet()->fromArray($aryData);
        $phpexcel->getActiveSheet()->setTitle('Sheet1');
        $phpexcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$fileName");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objwriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
        $objwriter->save('php://output');
        exit;
    }

    /**
     * 将一个有 pid text 的数据数组中的text进行重新赋值
     * 从而达到格式化显示父子关系
     * @param $param
     * @param int $pid
     * @param int $lvl
     * @return array
     */
    function selectTree($param, $pid = 0, $lvl = 0)
    {
        static $res = [];
        foreach ($param as $key => $vo) {
            if ($pid == $vo['pid']) {
                $vo['text'] =  ($lvl != 0 ? '|' : '') . str_repeat('---------', $lvl) . $vo['text'];
                $res[] = $vo;
                $temp = $lvl + 1;

                $this->selectTree($param, $vo['id'], $temp);
            }
        }
        return $res;
    }
}