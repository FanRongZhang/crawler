<?php
namespace frontend\controllers;

use app\services\MsgcodeService;
use app\services\CacheService;
use app\services\PageService;
use app\services\UserService;
use app\services\WechatService;
use common\models\User;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\web\Controller;
use common\models\Adminuser;


/**
 * 后台
 * Class IndexController
 * @package backend\controllers
 */
class BasewebController extends Controller
{

    public $title;

    public $keywords;

    public $description;

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
     * @var $needtologin bool 需要登录，默认不需要登录
     */
    public $needtologin;

    /**
     * 当前登录的用户
     * @var \common\models\User
     */
    public $user;

    public function returnPageCacheIfExists(){
        $string = CacheService::getCache($this->getPageCacheKey());
        if($string) {
            $this->response->content = $string;
            $this->response->send();
            exit(0);
        }
    }

    public function makePageCache($content, $timeout = 60){
        $key = $this->getPageCacheKey();
        CacheService::setCache($key, $content, $timeout);
    }

    private function getPageCacheKey(){
        return md5($this->getPageCacheUrl());
    }

    private function getPageCacheUrl(){
        return ( $this->isMobile() ? 'mobile:' : 'pc:' ) . $this->request->absoluteUrl;
    }

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
        $ary = PageService::getPageData($query,$page,$pageSize,$asArray);
        $this->pagination = $ary['pages'];
        return $ary;
    }

    /**
     * @param string $id the ID of this controller.
     * @param Module $module the module that this controller belongs to.
     * @param array $config name-value pairs that will be used to initialize the object properties.
     */
    public function __construct($id, $module, $config = [])
    {

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

    public function jsonpSuccess($data=[]){
        $this->response->format = \yii\web\response::FORMAT_JSONP;
        $callback = $this->getParam('callback');
        if(!$callback){
            $callback = 'callback';
        }
        exit( $callback  . '(' . json_encode([
            'code'=>MsgcodeService::OP_SUCCESS,
            'msg'=>MsgcodeService::getRetMsg(MsgcodeService::OP_SUCCESS),
            'data'=>$data
        ]) . ')');
    }

    public function jsonpFail($code=MsgcodeService::OP_FAILRE){
        $this->response->format = \yii\web\response::FORMAT_JSONP;
        $callback = $this->getParam('callback');
        if(!$callback){
            $callback = 'callback';
        }
        exit( $callback  . '(' . json_encode([
                'code'=>MsgcodeService::OP_FAILRE,
                'msg'=>MsgcodeService::getRetMsg(MsgcodeService::OP_FAILRE),
            ]) . ')');
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

    function isWeixin(){
        if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }

    function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }

}