<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css',
    ];
    public $js = [
        '//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js'
    ];
    public $depends = [
    ];
}
