<?php

?>

<style>
    .oneArticle *{
        color: white;
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
    foreach ($aryLinks as $oneLink):
    ?>
    <div class="oneArticle">
        <div class="title" onclick="$t = $(this).next()[0];$t.style.display = $t.style.display != 'block' ? 'block' : 'none';"><?= $oneLink['title'] ?></div>
        <div class="content">
            <?= $oneLink['content'] ?>
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
