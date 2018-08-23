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

        <nav class="bar bar-tab">
            <?php
            $current_i = 0;
            foreach ($contentTypes as $one) {
                ++$current_i;
                ?>
                <a class="tab-item <?= $current_i == 1 ? 'active' : '' ?>" href="<?= \yii\helpers\Url::toRoute([
                        '/content/list',
                        'content_type' => $one->id
                ]) ?>">
                    <span class="icon icon-home"></span>
                    <span class="tab-label"><?= Html::encode($one->name) ?></span>
                </a>
                <?php
            }
            ?>
            <a class="tab-item" href="/me/">
                <span class="icon icon-star"></span>
                <span class="tab-label">我的服务</span>
            </a>
        </nav>


        <div class="content"><?= $content ?></div>


    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
