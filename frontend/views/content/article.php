<?php
/* @var $article \common\models\Crawlerarticle */

$this->title = $article->title;
?>



<div class="card">
    <div class="card-header">
        <h1><?= \yii\helpers\Html::encode($article->title) ?></h1>
    </div>
    <div class="card-content">
        <h3 style="text-align: center;">时间：<?= \yii\helpers\Html::encode(date('Y-m-d',$article->article_time)) ?></h3>

        <?php
        $c = \yii\helpers\HtmlPurifier::process($article->content,[
                'HTML.Allowed' => 'div,p,br'
        ]);

        //算出广告语的字数
        $puri_c = \yii\helpers\HtmlPurifier::process($article->content,[
            'HTML.Allowed' => ''
        ]);
        $puri_c = str_replace(["\n","\r"],'',$puri_c);
        $p = mb_strrpos($puri_c,'更多');
        $length = mb_strlen($puri_c) - $p;

        $c = mb_substr($c,0, mb_strlen($c) - $length - 24);
        echo $c;
        ?>
    </div>
</div>