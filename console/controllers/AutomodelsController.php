<?php
namespace console\controllers;


class AutomodelsController extends \yii\console\Controller{
    /**
     * yii automodels/go
     * 自动生成数据库的MODEL层
     */
    public function actionGo($imigrate=false){
        $dbName = 'gongwuyuan';
        $aryTables = \Yii::$app->db->createCommand('select table_name,table_comment from information_schema.tables where table_schema=\''.$dbName.'\'')->queryAll();
        foreach($aryTables as $oneTable){
            $tableName = $oneTable['table_name'];
            $tableComment = $oneTable['table_comment'];

            /*
            if(strtolower($tableName) == 'user'){
                echo 'skip user table................' . PHP_EOL;
                continue;
            }
            */

            $fileC = '<?php'.PHP_EOL;
            $fileC .= 'namespace common\models;'.PHP_EOL;
            $fileC .= PHP_EOL;
            $fileC .= 'use Yii;'.PHP_EOL;
            $fileC .= '/**'.PHP_EOL;
            $fileC .= '* 代码自动生成 '.$tableName.'-'.$tableComment.'表的模型类 '.PHP_EOL;

            $aryColoumns = \Yii::$app->db->createCommand('select COLUMN_NAME,DATA_TYPE,COLUMN_COMMENT,COLUMN_TYPE,CHARACTER_MAXIMUM_LENGTH,COLUMN_KEY from information_schema.`COLUMNS` where table_schema=\''.$dbName.'\' and TABLE_NAME=\''.$tableName.'\';')->queryAll();
            foreach($aryColoumns as $oneColumn){
                $fileC .= '* @property '.self::getType($oneColumn['DATA_TYPE']).' $'.$oneColumn['COLUMN_NAME'] .'   '.$oneColumn['COLUMN_COMMENT']. PHP_EOL;
            }

            $fileC .= '*/'.PHP_EOL;
            $fileC .= 'class '.ucfirst($tableName).' extends \yii\db\ActiveRecord'.PHP_EOL;
            $fileC .= '{'.PHP_EOL;

            if(file_exists(dirname(__DIR__).'/../common/models/'.ucfirst($tableName).'Trait.php')){
                $fileC .='      use '.ucfirst($tableName).'Trait;' . PHP_EOL;
            }

            $fileC .= '     public static function tableName(){' . PHP_EOL;
            $fileC .= "         return '$tableName';" . PHP_EOL;
            $fileC .= '     }'. PHP_EOL;

            /*
            foreach($aryColoumns as $oneColumn){
                $fileC .= 'private $'.$oneColumn['COLUMN_NAME'].';'.PHP_EOL;
            }

            foreach($aryColoumns as $oneColumn){
                $fileC .= '     public function get'.$oneColumn['COLUMN_NAME'].'(){return $this->'.$oneColumn['COLUMN_NAME'].';}'.PHP_EOL;
                $fileC .= '     public function set'.$oneColumn['COLUMN_NAME'].'($value){$this->'.$oneColumn['COLUMN_NAME'].'=$value;return $this;}'.PHP_EOL;
            }
            */

            $fileC .= '}'.PHP_EOL;

            file_put_contents(dirname(__DIR__).'/../common/models/'.ucfirst($tableName).'.php',$fileC);

            echo 'table '.$tableName.' was build'.PHP_EOL;

            /**
             * 创建这个表的创建迁移文件
             */
            if($imigrate){

                $className = 'm170629_0'.substr(str_shuffle('1234567890'),0,5).'_'.$tableName;

                $fileC = '<?php'.PHP_EOL;
                $fileC .= 'use yii\db\Migration;'.PHP_EOL;
                $fileC .= '/**'.PHP_EOL;
                $fileC .= "* 根据数据库自动生成表的迁移创建，表 $tableName - $tableComment".PHP_EOL;
                $fileC .= '*/'.PHP_EOL;
                $fileC .= 'class '.$className.' extends Migration'.PHP_EOL;
                $fileC .= '{'.PHP_EOL;


                $fileC .= '     public function up(){' . PHP_EOL;
                $fileC .= "         \$this->createTable('$tableName', [ " . PHP_EOL;

                foreach($aryColoumns as $oneColumn){
                    if($oneColumn['COLUMN_KEY'] && $oneColumn['COLUMN_KEY']=='PRI'){
                        $fileC .= '\''.$oneColumn['COLUMN_NAME'].'\' => $this->primaryKey(),'.PHP_EOL;
                    }else{
                        $fileC .= "'".$oneColumn['COLUMN_NAME'].'\' => ';
                        $fileC .= '$this->'.self::getImigrateType($tableName, $oneColumn['COLUMN_NAME'] , $oneColumn['DATA_TYPE'],$oneColumn['CHARACTER_MAXIMUM_LENGTH']);
                        $fileC .= '->comment(\''.$oneColumn['COLUMN_COMMENT'].'\')';
                        $fileC .= "->notNull()";
                        $fileC .= ','.PHP_EOL;
                    }
                }

                $fileC .= "     ]);" . PHP_EOL;

                $fileC .= '     }'. PHP_EOL;

                $fileC .= '     public function down(){' . PHP_EOL;
                $fileC .= "         echo 'i dont want to down it $tableName';" . PHP_EOL;
                $fileC .= "         return false;" . PHP_EOL;
                $fileC .= '     }'. PHP_EOL;


                $fileC .= '     }'. PHP_EOL;
                file_put_contents(dirname(__DIR__).'/migrations/'.$className.'.php',$fileC);

                echo 'imigrate for table '.$tableName.' was build'.PHP_EOL;

            }

        }

        echo count($aryTables) .' tables were done!';
    }

    private static function getImigrateType($tableName, $columnName , $type, $length=null){
        $type = strtolower($type);
        if($type=='varchar'){
            return "string($length)->defaultValue('')";
        }
        if($type=='char'){
            return "char($length)->defaultValue('')";
        }
        if($type=='int'||strpos($type,'int')){
            return 'integer()';
        }
        if($type=='decimal'||strpos($type,'decimal')||$type=='float'){
            return 'decimal(10,2)->defaultValue(0)';
        }
        if($type=='datetime'){
            return 'dateTime()';
        }
        //在有些版本里面text/blod类型不能有默认值
        if($type=='text'||strpos($type,'text')){
            return "text()";
        }
        if($type=='blob'||strpos($type,'blob')){
            return "binary()";
        }
        if($type=='enum'){
            echo ' WARNING: ' . $tableName . ' . ' . $columnName . ' is ' . $type . PHP_EOL;
            exit;
        }
        return "$type()";
    }

    private static function getType($type){
        $type = strtolower($type);
        if($type=='char'||$type=='text'||strpos($type,'char')){
            return 'string';
        }
        if($type=='int'||strpos($type,'int')){
            return 'integer';
        }
        if($type=='decimal'||strpos($type,'decimal')){
            return 'float';
        }
        return $type;
    }
}