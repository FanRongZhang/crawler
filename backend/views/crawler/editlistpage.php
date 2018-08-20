<?php
/* @var $domains common\models\Crawlerdomain[] */
/* @var $crawlerlistpage common\models\Crawlerarticlelistpage */
/* @var $categories common\models\Articlecategory[] */
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

<script>
    var findArea = function (txt,domName) {
        var select = getFirstElementByName(domName);
        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].text.indexOf(txt) != -1) {
                select.options[i].selected = true;
                break;
            }
        }
    }
</script>

<div style="background-color: #333;color: white;border: solid 1px #1295bf;" id="testResult">

</div>

<form method="post" enctype="multipart/form-data"  class="my-form" id="form1">
    <table class="table table-border table-bordered my-table">
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
                <th>采集网页名称：</th>
                <td>
                    <input type="text" name="name" value="<?= $crawlerlistpage->name ?>" />
                </td>
            </tr>
            <tr>
                <th>网页地址（网址）：</th>
                <td>
                    <input type="text" name="url" id="url" value="<?= $crawlerlistpage->url ?>" />
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
                <th>合适的分类【仅供参考】：</th>
                <td>
                    <select  name="articlecategory">
                    <?php
                    foreach ($categories as $oneCategory):
                    ?>
                    <option value="<?= $oneCategory->id ?>"   <?= $crawlerlistpage->articlecategory == $oneCategory->id ? 'selected' : '' ?>   ><?= $oneCategory->text ?></option>
                    <?php
                    endforeach;
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>合适的考试【仅供参考】：</th>
                <td>
                    <select name="examid">
                        <?php
                        foreach ($exams as $oneExam):
                            ?>
                            <option value="<?= $oneExam->id ?>"  <?= $oneExam->id == $crawlerlistpage->examid ? 'selected' : '' ?>  ><?= $oneExam->name ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                    <input type="text"  onkeyup="findArea($(this).val(),'examid')" style="width: 120px;" placeholder="搜索考试"/>
                </td>
            </tr>
            <tr>
                <th>资讯链接selector：</th>
                <td>
                    <input type="text" name="xpath_a"  id="xpath_a" value="<?= $crawlerlistpage->xpath_a ?>" />
                </td>
            </tr>
            <tr>
                <th>第几个A标签：</th>
                <td>
                    <input type="text" name="linkindex" id="linkindex"  value="<?= $crawlerlistpage->linkindex ?>" style="width: 100px;"  /> [资讯链接selector无法直接获取a标签时候，采用资讯链接selector的上一级同时使用simple_dom_html进行a标签获取]
                </td>
            </tr>
            <tr>
                <th>资讯内容selector：</th>
                <td>
                    <input type="text" name="xpath_content"  id="xpath_content" value="<?= $crawlerlistpage->xpath_content ?>" />
                </td>
            </tr>
            <tr>
                <th>资讯内容翻页selector：</th>
                <td>
                    <input type="text" name="xpath_content_path" id="xpath_content_path" placeholder="没有可不填" value="<?= $crawlerlistpage->xpath_content_path ?>" />
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


<script>
    //执行一个laydate实例
    laydate.render({
        elem: '#starttime', //指定元素
        type: 'datetime'
    });
</script>
<script>
    //执行一个laydate实例
    laydate.render({
        elem: '#endtime', //指定元素
        type: 'datetime'
    });
</script>