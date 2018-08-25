<?php

?>

<style>
    .oneArticle *{
        color: brown;
    }
    .oneArticle .content{
        display: none;
    }
    .oneArticle{
        border: solid 1px #08c;
    }
</style>

<div>
    <?php
    foreach ($aryLinks as $one):
    ?>
    <div class="oneArticle">
        <div class="title" onclick="$t = $(this).next()[0];$t.style.display = $t.style.display != 'block' ? 'block' : 'none';">
            <span><?= $one['title'] ?></span>
            <span><?= date('Y-m-d',$one['article_time']) ?></span>
        </div>
        <div class="content">
            <?= $one['content'] ?>
        </div>
    </div>
    <?php
    endforeach;
    ?>

    <hr>
    <?php
        echo '返回时间：' . date('Y-m-d H:i:s');
    ?>
</div>
