<?php
namespace common\models;

use Yii;
/**
* 代码自动生成 migration-表的模型类 
* @property string $version   
* @property integer $apply_time   
*/
class Migration extends \yii\db\ActiveRecord
{
     public static function tableName(){
         return 'migration';
     }
}
