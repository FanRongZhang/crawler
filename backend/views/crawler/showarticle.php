<?php
/* @var $showarticle common\models\Crawlerarticle */

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
<table class="my-table-vertical">
    <tr>
        <th>标题：</th>
        <td><?= $showarticle->title ?></td>
    </tr>
    <tr>
        <th>关键字：</th>
        <td><?= $showarticle->keyword ?></td>
    </tr>
    <tr>
        <th>描述：</th>
        <td><?= $showarticle->description ?></td>
    </tr>
    <tr>
        <th>正文：</th>
        <td><?= $showarticle->content ?></td>
    </tr>
</table>
