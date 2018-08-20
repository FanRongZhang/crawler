<?php
/* @var $list common\models\Crawlerdomain[] */
/* @var $pages \yii\data\Pagination */

?>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i>
    <a href="#"> 首页</a>
    <span class="c-gray en">&gt;</span>
    <a href="#">系统管理</a>
    <span class="c-gray en">&gt;</span>
    <a href="">基本设置</a>
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container">
    <div class="tabBar cl">
        <a href="/crawler/index">爬虫管理</a>
        <a href="/crawler/article">资讯管理</a>
        <a href="/crawler/domains"  class="active">域名管理</a>
    </div>
<div class="wrapper-header">
    <h1><a data-href="/crawler/createdomain" data-title="创建新的域名" class="btn btn-primary open-newWindow"><span class="glyphicon glyphicon-plus"></span> 创建新的域名</a></h1>
</div>


<table class="my-table">
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
        <a class="my-menu open-newWindow" data-title="修改域名" data-href="/crawler/editdomain?id=<?= $one->id ?>"><span class="glyphicon glyphicon-pencil"></span> 修改</a>
        <a class="my-menu open-newWindow" data-title="创建资讯任务列表" data-href="/crawler/createlistpage?domainid=<?= $one->id ?>"><span class="glyphicon glyphicon-plus"></span> 创建资讯任务列表</a>
    </td>
</tr>
<?php
endforeach;
?>
</table>

