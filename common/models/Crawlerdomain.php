<?php
namespace common\models;

use Yii;
/**
* 代码自动生成 crawlerdomain-抓取的域名表的模型类 
* @property integer $id   
* @property string $name   域名名称
* @property string $domain   域名，一级域名是
* @property integer $enable   启用
* @property integer $createtime   创建时间int
* @property string $xpath_a   列表a标签的XPATH路径
* @property string $xpath_content   a标签链接的页面里面的咨询主体内容的XPATH路径
* @property string $xpath_content_path   资讯主体内容页的分页a标签XPATH路径
* @property string $pageencode   域名下的网页编码，好让下面的页面页在UI上面事先给选择该编码
*/
class Crawlerdomain extends \yii\db\ActiveRecord
{
     public static function tableName(){
         return 'crawlerdomain';
     }
}
