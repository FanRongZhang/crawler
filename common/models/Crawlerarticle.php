<?php
namespace common\models;

use Yii;
/**
* 代码自动生成 crawlerarticle-抓取到的资讯结果保存数据库表表的模型类 
* @property integer $id   
* @property integer $domainid   所属域名ID
* @property integer $listpageid   列表页ID
* @property string $url   地址是多少，比如http://www.xxx.gov.cn/100.html
* @property string $title   资讯标题
* @property string $keyword   关键字
* @property string $description   描述
* @property integer $article_time   资讯时间
* @property longtext $content   资讯内容
* @property integer $is_public   公开
* @property integer $is_deleted   已删除
* @property integer $createtime   创建时间int
*/
class Crawlerarticle extends \yii\db\ActiveRecord
{
     public static function tableName(){
         return 'crawlerarticle';
     }
}
