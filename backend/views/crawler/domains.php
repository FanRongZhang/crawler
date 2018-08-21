<?php
/* @var $list common\models\Crawlerdomain[] */
/* @var $pages \yii\data\Pagination */

?>

<h1><a href="/crawler/createdomain" data-title="创建新的域名" class="btn btn-primary open-newWindow"><span class="glyphicon glyphicon-plus"></span> 创建新的域名</a></h1>


<table class="table">
    <tr>
        <th>名称</th>
        <th>域名</th>
        <th>启用</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>

<?php
foreach ($list as $one):
?>
<tr>
    <td>
        <?= $one->name ?>
    </td>
    <td>
        <?= $one->domain ?>
    </td>
    <td>
        <?= $one->enable ? '是' : '否' ?>
    </td>
    <td>
        <?= $one->createtime ?>
    </td>
    <td>
        <a class="my-menu open-newWindow" href="/crawler/editdomain?id=<?= $one->id ?>"><span class="glyphicon glyphicon-pencil"></span> 修改</a>
        <a class="my-menu open-newWindow" href="/crawler/createlistpage?domainid=<?= $one->id ?>"><span class="glyphicon glyphicon-plus"></span> 创建资讯任务列表</a>
    </td>
</tr>
<?php
endforeach;
?>
</table>

