<?php
namespace app\services;

class HtmlFormatService
{

    public static function html2text($str)
    {
        $str = preg_replace("/<style .*?<\\/style>/is", "", $str);
        $str = preg_replace("/<script .*?<\\/script>/is", "", $str);
        //$str = preg_replace("/<br \\s*\\/>/i", ">>>>", $str);
        //$str = preg_replace("/<\\/?p>/i", ">>>>", $str);
        //$str = preg_replace("/<\\/?td>/i", "", $str);
        //$str = preg_replace("/<\\/?div>/i", ">>>>", $str);
        $str = preg_replace("/<\\/?blockquote>/i", "", $str);
        //$str = preg_replace("/<\\/?li>/i", ">>>>", $str);
        $str = preg_replace("/ /i", " ", $str);
        $str = preg_replace("/ /i", " ", $str);
        $str = preg_replace("/&/i", "&", $str);
        $str = preg_replace("/&/i", "&", $str);
        $str = preg_replace("/</i", "<", $str);
        $str = preg_replace("/</i", "<", $str);
        $str = preg_replace("/“/i", '"', $str);
        $str = preg_replace("/&ldquo/i", '"', $str);
        $str = preg_replace("/‘/i", "'", $str);
        $str = preg_replace("/&lsquo/i", "'", $str);
        $str = preg_replace("/'/i", "'", $str);
        $str = preg_replace("/&rsquo/i", "'", $str);
        $str = preg_replace("/>/i", ">", $str);
        $str = preg_replace("/>/i", ">", $str);
        $str = preg_replace("/”/i", '"', $str);
        $str = preg_replace("/&rdquo/i", '"', $str);
        $str = strip_tags($str);
        $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/&#.*?;/i", "", $str);
        return $str;
    }

    public static function clearHtmlStyle($content)
    {
        $content = preg_replace("/<style .*?<\\/style>/is", "", $content);
        $content = preg_replace("/<script .*?<\\/script>/is", "", $content);
        $content = preg_replace("/(.*?style=\\').*?(\\'.*?)/i",'$1$2',$content);
        return preg_replace('/(.*?style=\\").*?(\\".*?)/i','$1$2',$content);
    }

}