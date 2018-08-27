<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$contentTypes = \common\models\Crawlercontenttype::findAll([
        'show_in_indexpage' => 1
]);

$this->title =  $this->title . '--十大教育';

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<div class="page-group">
    <div class="page page-current">
        <header class="bar bar-nav">
            <h1 class="title"><?= Html::encode($this->title) ?></h1>
        </header>

        <?php
        $content_type = isset($_GET['content_type']) ? $_GET['content_type'] : 0;
        ?>

        <nav class="bar bar-tab">
            <a class="tab-item <?= $content_type == 0 ? 'active' : '' ?>" href="/">
                <span class="icon icon-star"></span>
                <span class="tab-label">综合信息</span>
            </a>
            <?php
            foreach ($contentTypes as $one) {
                ?>
                <a class="tab-item <?= $content_type == $one->id ? 'active' : '' ?>" href="<?= \yii\helpers\Url::toRoute([
                        '/content/list',
                        'content_type' => $one->id
                ]) ?>">
                    <span class="icon icon-home"></span>
                    <span class="tab-label"><?= Html::encode($one->name) ?></span>
                </a>
                <?php
            }
            ?>
            <!--
            <a class="tab-item" href="/me/">
                <span class="icon icon-star"></span>
                <span class="tab-label">我的服务</span>
            </a>
            -->
        </nav>


        <?= $content ?>
    </div>

    <div class="panel-overlay"></div>
    <!-- Left Panel with Reveal effect -->
    <div class="panel panel-left panel-reveal theme-dark" id='panel-left-demo'>
        <div class="content-block">
            <p><a href="#" class="close-panel">关闭</a></p>
        </div>
        <div class="list-block">
            <ul>
                <li>
                    <div class="item-content">
                        <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                        <div class="item-inner">
                            <div class="item-title label">开启夜间模式</div>
                            <div class="item-input">
                                <label class="label-switch">
                                    <input type="checkbox">
                                    <div class="checkbox"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
