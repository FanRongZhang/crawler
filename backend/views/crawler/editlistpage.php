<?php
/* @var $domains common\models\Crawlerdomain[] */
/* @var $crawlerlistpage common\models\Crawlerarticlelistpage */
/* @var $contenttypes common\models\Crawlercontenttype[] */
?>
<script src="https://cdn.bootcss.com/jquery.serializeJSON/2.8.1/jquery.serializejson.js"></script>


<style>
    input[type="text"]{
        width: 1000px;
        line-height: 20px;
    }
    td{
        line-height: 20px;
        height: 20px;
    }
    .my-form .my-table td {text-align: left;}
</style>

<script>
    var test = function () {
        $.ajax({
            url:'/crawler/test?r='+Math.random(),
            data: $("#form1").serializeJSON(),
            success:function ($html) {
                $('#testResult').html($html);
            }
        })
    }
</script>


<div style="background-color: #333;color: white;border: solid 1px #1295bf;" id="testResult">

</div>

<form method="post" enctype="multipart/form-data"  class="my-form" id="form1">
    <table class="table">
        <tbody>
            <tr>
                <th style="width: 250px;">域名：</th>
                <td>
                    <select name="domainid">
                    <?php
                    foreach ($domains as $oneDomain):
                    ?>
                    <option value="<?= $oneDomain->id ?>"   <?= $crawlerlistpage->domainid == $oneDomain->id ? 'selected' : '' ?>   > <?= $oneDomain->domain ?> <?= $oneDomain->name ?>  </option>
                    <?php
                    endforeach;
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th style="width: 250px;">内容类型：</th>
                <td>
                    <select name="content_type">
                        <?php
                        foreach ($contenttypes as $one):
                            ?>
                            <option value="<?= $one->id ?>"   <?= $crawlerlistpage->content_type == $one->id ? 'selected' : '' ?>    >   <?= $one->name ?>  </option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>采集网页名称：</th>
                <td>
                    <input type="text" name="name" value="<?= $crawlerlistpage->name ?>" />
                </td>
            </tr>
            <tr>
                <th>网页地址（网址）：</th>
                <td>
                    <input type="text" name="url"  value="<?= $crawlerlistpage->url ?>" />
                </td>
            </tr>
            <tr>
                <th>网页编码：</th>
                <td>
                    <select name="pageencode">
                        <option value="UTF-8"  <?= $crawlerlistpage->pageencode == 'UTF-8' ? 'selected' : '' ?>  >UTF-8</option>
                        <option value="GB2312"  <?= $crawlerlistpage->pageencode == 'GB2312' ? 'selected' : '' ?>  >GB2312</option>
                        <option value="GBK"  <?= $crawlerlistpage->pageencode == 'GBK' ? 'selected' : '' ?>  >GBK</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>资讯链接selector(列表页)：</th>
                <td>
                    <input type="text" name="selector_a"  value="<?= \yii\helpers\Html::encode($crawlerlistpage->selector_a) ?>" />
                </td>
            </tr>
            <tr>
                <th>第几个A标签(列表页)：</th>
                <td>
                    <input type="text" name="linkindex" value="<?= $crawlerlistpage->linkindex ?>" style="width: 100px;"  /> [资讯链接selector无法直接获取a标签时候，采用资讯链接selector的上一级同时使用simple_dom_html进行a标签获取]
                </td>
            </tr>
            <tr>
                <th>咨询时间(列表页)：</th>
                <td>
                    <input type="text" name="selector_time" value="<?= \yii\helpers\Html::encode($crawlerlistpage->selector_time) ?>"   />
                </td>
            </tr>
            <tr>
                <th>资讯内容selector：</th>
                <td>
                    <input type="text" name="selector_content" value="<?= \yii\helpers\Html::encode($crawlerlistpage->selector_content) ?>" />
                </td>
            </tr>
            <tr>
                <th>资讯内容翻页selector：</th>
                <td>
                    <input type="text" name="selector_content_page_path" placeholder="没有可不填" value="<?= \yii\helpers\Html::encode($crawlerlistpage->selector_content_page_path) ?>" />
                </td>
            </tr>
            <tr>
                <th>启用：</th>
                <td>
                    <select name="enable">
                        <option value="1"  <?= $crawlerlistpage->enable == 1 ? 'selected' : '' ?>   >是</option>
                        <option value="0"  <?= $crawlerlistpage->enable == 0 ? 'selected' : '' ?>   >否</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>任务开始时间：</th>
                <td>
                    <input type="text" name="starttime" value="<?= date('Y-m-d H:i:s', $crawlerlistpage->starttime) ?>"  placeholder="表示该执行列表该指定的任务时间内可以对其进行任务执行操作"/>
                </td>
            </tr>
            <tr>
                <th>任务结束时间：</th>
                <td>
                    <input type="text" name="endtime" value="<?= date('Y-m-d H:i:s', $crawlerlistpage->endtime) ?>" placeholder="表示该执行列表该指定的任务时间内可以对其进行任务执行操作"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    <input class="btn btn-success" type="submit" value="提交" />
                    <input class="btn btn-warning" type="button" value="测试" onclick="test()"/>
                </td>
            </tr>
        </tbody>
    </table>
</form>