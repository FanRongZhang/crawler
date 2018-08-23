<?php
namespace common\models;

use Yii;
/**
* 代码自动生成 crawlerarticlelistpage-资讯列表页，只抓取URL字段里面的地址，如果需要抓取第二页就创建一个新记录表的模型类 
* @property integer $id   
* @property integer $process_id   指定哪个进程ID进行处理，比如0
* @property integer $domainid   所属域名ID
* @property string $name   咨询列表页的名称，比如湖北公务员招考列表页
* @property integer $content_type   内容类型
* @property string $url   地址是多少，比如http://www.xxx.gov.cn/100.html
* @property integer $is_auto_public   自动发布资讯，通过设置crawlerarticle的is_public
* @property string $pageencode   网页编码
* @property string $selector_a   列表页面里面的a标签XPATH路径
* @property integer $linkindex   a标签selector选取的第几个a标签,默认第一个,即0
* @property string $selector_time   列表页资讯时间 xpath
* @property string $selector_content   咨询主体内容的XPATH路径
* @property string $selector_content_page_path   资讯主体内容页的分页a标签XPATH路径
* @property integer $enable   启用
* @property integer $is_normal   是否正常状态
* @property string $unnormal_system_mark   不正常情况的异常记录
* @property integer $working_status   正处在工作状态中
* @property integer $start_working_time_last_time   最后一次开始工作时间
* @property integer $end_working_time_last_time   最后一次结束工作时间
* @property integer $createtime   创建时间int
* @property integer $starttime   任务有效开始时间
* @property integer $endtime   任务有效结束时间
*/
class Crawlerarticlelistpage extends \yii\db\ActiveRecord
{
     public static function tableName(){
         return 'crawlerarticlelistpage';
     }
}
