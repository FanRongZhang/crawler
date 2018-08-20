<?php
/* @var $list common\models\Crawlerarticle[] */
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
        <a href="/crawler/article"  class="active">资讯管理</a>
        <a href="/crawler/domains">域名管理</a>
    </div>

<table class="my-table">
    <tr>
        <th width="50">ID</th>
        <th width="460">标题</th>
        <th width="400">来源网址</th>
        <th width="100">资讯分类</th>
        <th>创建时间</th>
        <th>是否已经处理</th>
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
        <?= \common\models\Articlecategory::findOne($one->articlecategory)->text ?>
    </td>
    <td>
        <?= date('Y-m-d H:i:s',$one->createtime) ?>
    </td>
    <td>
        <span style="color: <?= $one->hadhandle ? 'green' : '' ?>"><?= $one->hadhandle ? '是' : '否' ?></span>
    </td>
    <td>
        <a  class="my-menu open-newWindow" onclick="this.style.color='darkgreen';"  target="_blank" data-title="<?= $one->title ?>-查看" data-href="/crawler/showarticle?id=<?= $one->id ?>"><span class="Hui-iconfont Hui-iconfont-yanjing"></span> 查看</a>
        <a  class="my-menu open-newWindow btnUse" title="使用该资讯"  onclick="this.style.color='darkgreen';"  target="_blank" data-title="<?= $one->title ?>-使用" data-href="/crawler/usethearticle?id=<?= $one->id ?>"><span class="Hui-iconfont Hui-iconfont-selected"></span> 使用</a>
        <a class="my-menu"  onclick="this.style.color='darkgreen';" target="_blank" href="/crawler/deletearticle?id=<?= $one->id ?>"><span class="Hui-iconfont Hui-iconfont-del2"></span> 删除</a>
    </td>
</tr>
<?php
endforeach;
?>
</table>

