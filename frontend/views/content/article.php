<?php
/* @var $article \common\models\Crawlerarticle */

$this->title = $article->title;
?>


<div class="content">
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

    <?php

    $aryUrls = \QL\QueryList::html($article->content)->rules([  //设置采集规则
        // 采集所有a标签的href属性
        'link' => ['a','href'],
        // 采集所有a标签的文本内容
        'text' => ['a','text']
    ])->query()->getData();

    $file_c = 0;
    ?>

    <div class="card-footer">
        附件下载：<br>
        <ul>
        <?php
        foreach ($aryUrls as $one) {
            $downUrl = $one['link'];
            $ext = pathinfo($downUrl, PATHINFO_EXTENSION);
            if (in_array($ext, ['doc', 'xls', 'docx', 'pdf', 'rar', 'zip'])) {
                ++$file_c;
                ?>

                <li><a href="<?= $downUrl ?>" target="_blank" ><?= $one['text'] ?></a></li>

        <?php
            }
        }

        if($file_c == 0){
            echo '<li>无附件</li>';
        }
        ?>
        </ul>
    </div>


</div>
</div>