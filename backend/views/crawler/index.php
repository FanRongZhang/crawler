<?php
/* @var $list common\models\Crawlerarticlelistpage[] */
/* @var $pages \yii\data\Pagination */
/* @var $exam \common\models\Exam */

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
        <a href="/crawler/index" class="active">爬虫管理</a>
        <a href="/crawler/article">资讯管理</a>
        <a href="/crawler/domains">域名管理</a>
    </div>



<form class="listdata-form" id="searchForm" method="post">
    <div class="wrapper-header" style="margin-top: 0;">
        <div style="float:left;">
         <a data-href="/crawler/createdomain?examid=<?= $exam ? $exam->id : '' ?>" data-title="创建域名列表" class="btn btn-primary open-newWindow"><span class="glyphicon glyphicon-plus"></span> 创建域名列表</a>
        </div>
            <div style="float: left;margin-left: 20px;">
                <span>异常情况：</span>
                <select name="is_normal">
                    <option value="1">正常</option>
                    <option value="0">异常</option>
                </select>
            </div>

            <div  style="float: left;margin-left: 20px;">
                <a href="#" class="btn btn-success" onclick="searchForm.submit()"><span class="glyphicon glyphicon-search"></span> 查询</a>
            </div>
    </div>
</form>

<table class="my-table">
    <tr>
        <th>ID</th>
        <th style="width: 350px;">名称</th>
        <th style="width: 400px;">网址</th>
        <th style="width: 150px;">处理进程ID</th>
        <th style="width: 150px;">资讯分类</th>
        <th style="width: 150px;">启用</th>
        <th style="width: 150px;">是否异常</th>
        <th style="width: 150px;">异常信息</th>
        <th style="width: 150px;">正在工作中</th>
        <th style="width: 150px;">上次工作开始时间</th>
        <th style="width: 150px;">上次工作结束时间</th>
        <th style="width: 150px;">网址创建时间</th>
        <th style="width: 350px;">操作</th>
    </tr>
<?php
foreach ($list as $one):
?>
<tr>
    <td><?= $one->id ?></td>
    <td>
        <?= $one->name ?>
    </td>
    <td>
        <?= $one->url ?>
    </td>
    <td>
        <?= $one->process_id ?>
    </td>
    <td>
        <?= \common\models\Articlecategory::findOne($one->articlecategory)->text ?>
    </td>
    <td>
        <?= $one->enable ? '是' : '否'?>
    </td>
    <td>
        <?= $one->is_normal ? '<span style="color: green;">正常</span>' : '<span style="color: red;">异常</span>' ?>
    </td>
    <td>
        <?= $one->unnormal_system_mark ?>
    </td>
    <td>
        <?= $one->working_status ? '是' : '否' ?>
    </td>
    <td>
        <?= date('Y-m-d H:i:s',$one->start_working_time_last_time) ?>
    </td>
    <td>
        <?= date('Y-m-d H:i:s',$one->end_working_time_last_time) ?>
    </td>
    <td>
        <?= date('Y-m-d H:i:s',$one->createtime) ?>
    </td>
    <td style="padding: 0;">
        <a class="my-menu open-newWindow" data-title="修改咨询"  data-href="/crawler/editlistpage?id=<?= $one->id ?>"><span class="Hui-iconfont Hui-iconfont-edit"></span> 修改</a>
        <a class="my-menu"  href="/crawler/marktonormal?id=<?= $one->id ?>" target="_blank"><span class="Hui-iconfont Hui-iconfont-shenhe-tongguo"></span> 标记为正常</a>
    </td>
</tr>
<?php
endforeach;
?>
</table>

