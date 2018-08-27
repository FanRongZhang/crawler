<?php
/* @var $list common\models\Crawlerarticlelistpage[] */
/* @var $pages \yii\data\Pagination */

?>


<form class="listdata-form" id="searchForm" method="post">
    <div class="wrapper-header" style="margin-top: 0;">
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

<table class="table">
    <tr>
        <th>ID</th>
        <th >名称</th>
        <th >网址</th>
        <th >处理进程ID</th>
        <th >启用</th>
        <th >是否异常</th>
        <th >异常信息</th>
        <th >正在工作中</th>
        <th >上次工作开始时间</th>
        <th >上次工作结束时间</th>
        <th >网址创建时间</th>
        <th >操作</th>
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
        <a  href="/crawler/editlistpage?id=<?= $one->id ?>"><span class="Hui-iconfont Hui-iconfont-edit"></span> 修改</a>
        <a href="/crawler/marktonormal?id=<?= $one->id ?>" target="_blank"><span class="Hui-iconfont Hui-iconfont-shenhe-tongguo"></span> 标记为正常</a>
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