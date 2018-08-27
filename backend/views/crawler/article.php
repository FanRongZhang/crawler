<?php
/* @var $list common\models\Crawlerarticle[] */
/* @var $pages \yii\data\Pagination */

?>


<table class="table">
    <tr>
        <th width="50">ID</th>
        <th width="460">标题</th>
        <th width="400">来源网址</th>
        <th>创建时间</th>
        <th width="220">操作</th>
    </tr>
<?php
foreach ($list as $one):
?>
<tr>
    <td>
        <?= $one->id ?>
    </td>
    <td>
        <?= $one->title ?>
    </td>
    <td>
        <?= $one->url ?>
    </td>
    <td>
        <?= date('Y-m-d H:i:s',$one->createtime) ?>
    </td>
    <td>
        <a  class="my-menu open-newWindow" onclick="this.style.color='darkgreen';"  target="_blank" data-title="<?= $one->title ?>-查看" data-href="/crawler/showarticle?id=<?= $one->id ?>"><span class="Hui-iconfont Hui-iconfont-yanjing"></span> 查看</a>
        <a class="my-menu"  onclick="this.style.color='darkgreen';" target="_blank" href="/crawler/deletearticle?id=<?= $one->id ?>"><span class="Hui-iconfont Hui-iconfont-del2"></span> 删除</a>
    </td>
</tr>
<?php
endforeach;
?>
</table>


<?php

echo \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    'firstPageLabel'=>true,
    'lastPageLabel'=>true,
    'maxButtonCount'=>10
]);
?>