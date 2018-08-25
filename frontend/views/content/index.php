<?php
/* @var $articles \common\models\Crawlerarticle[] */
?>


<div>
    <ul>
        <?php
        foreach ($articles as $one) {
            ?>
        <li>
            <a href="/content/article?id=<?= $one->id ?>">
                <?= \yii\helpers\Html::encode($one->title) ?>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <?= \yii\helpers\Html::encode(date('Y-m-d',$one->article_time)) ?>
            </a>
        </li>
            <?php
        }
        ?>
    </ul>
</div>