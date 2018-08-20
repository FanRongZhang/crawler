<?php

namespace app\services;
use common\models\Articlecategory;
use common\models\Exam;
use common\models\Examtype;
use common\models\Model;
use common\models\Publicnotice;
use common\models\Region;
use EasyWeChat\ShakeAround\Page;
use yii\db\Query;

/**
 * 网页地址请求参数处理，依赖$_GET
 * @package app\services
 */
class UrlQueryService{
    private function __construct(){
    }
    private function __clone(){
    }

    public static function replaceOrAddParam($name,$value){
        $_G = $_GET;
        $_G[$name] = $value;
        return http_build_query($_G);
    }

    public static function replaceOrAddParams($aryParam){
        $_G = $_GET;
        foreach ($aryParam as $k => $v){
            $_G[$k] = $v;
        }
        return http_build_query($_G);
    }

    public static function removeTheParam($name){
        $_G = $_GET;
        if(is_string($name)) {
            unset($_G[$name]);
        }elseif(is_array($name)){
            foreach ($name as $_n){
                unset($_G[$_n]);
            }
        }
        return http_build_query($_G);
    }


//第一个是原串,第二个是 部份串
    public  static function startWith($str, $needle) {
        return strpos($str, $needle) === 0;
    }

//第一个是原串,第二个是 部份串
    public static function endWith($haystack, $needle) {
        $length = strlen($needle);
        if($length == 0)
        {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }


    public static function getUrlByHtml($html, $urlInAddressBar, $oldUrlAsKey = false)
    {
        $pattern = "'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1) (.*?)\\1 | ([^\s\>]+))'isx";
        preg_match_all($pattern, $html, $match);
        $match = array_merge($match[2], $match[3]);
        $hrefs = array_flip(array_flip(array_filter($match)));

        if($oldUrlAsKey){
            $aryNewHref = [];
            foreach ($hrefs as $oldUrl){
                $aryNewHref[$oldUrl] = self::formatUrl($oldUrl, $urlInAddressBar);
            }
            return $aryNewHref;
        }

        foreach ($hrefs as $key => $href) {
            $hrefs[$key] = self::formatUrl($href, $urlInAddressBar);
        }
        return array_flip(array_flip($hrefs));
    }

    public static function formatUrl($urlInHtml, $urlInAddressBar)
    {
        if (strlen($urlInHtml) > 0) {
            $I1 = str_replace([chr(34), chr(39)], '', $urlInHtml);
        } else {
            return $urlInHtml;
        }
        $url_parsed = parse_url($urlInAddressBar);
        $scheme = $url_parsed['scheme'];
        if ($scheme != '') {
            $scheme .= '://';
        }
        $host = $url_parsed['host'];
        $l3 = $scheme . $host;
        if (strlen($l3) == 0) {
            return $urlInHtml;
        }
        $path = dirname($url_parsed['path']);
        if ($path[0] == '\\') {
            $path = '';
        }
        $pos = strpos($I1, '#');
        if ($pos > 0) {
            $I1 = substr($I1, 0, $pos);
        }
        //判断类型
        if (preg_match("/^(http|https|ftp):(\/\/|\\\\)(([\w\/\\\+\-~`@:%])+\.)+([\w\/\\\.\=\?\+\-~`@\':!%#]|(&)|&)+/i", $I1)) {
            return $I1;
        } elseif ($I1[0] == '/') {
            return $I1 = $l3 . $I1;
        } elseif (substr($I1, 0, 3) == '../') {
            //相对路径
            while (substr($I1, 0, 3) == '../') {
                $I1 = substr($I1, strlen($I1) - (strlen($I1) - 3), strlen($I1) - 3);
                if (strlen($path) > 0) {
                    $path = dirname($path);
                }
            }
            return $I1 = $path == '/' ? $l3 . $path . $I1 : $l3 . $path . "/" . $I1;
        } elseif (substr($I1, 0, 2) == './') {
            return $I1 = $l3 . $path . substr($I1, strlen($I1) - (strlen($I1) - 1), strlen($I1) - 1);
        } elseif (strtolower(substr($I1, 0, 7)) == 'mailto:' || strtolower(substr($I1, 0, 11)) == 'javascript:') {
            return false;
        } else {
            return $I1 = $l3 . $path . '/' . $I1;
        }
    }

}