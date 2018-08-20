<?php
/* @var $domains common\models\Crawlerdomain[] */
/* @var $domain common\models\Crawlerdomain */
/* @var $exam common\models\Exam */
/* @var $domainid int */
/* @var $categories common\models\Articlecategory[] */
?>

<script src="https://cdn.bootcss.com/jquery.serializeJSON/2.8.1/jquery.serializejson.js"></script>

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

    <?php
    $aryGet = $aryParam;
    if(isset($aryGet['domainid'])){
        unset($aryGet['domainid']);
    }
    ?>
    var changeDomain = function (domainID) {
        location.href = '?<?= http_build_query($aryGet) ?>&domainid=' + domainID;
    }
</script>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i>
    <a href="#"> 首页</a>
    <span class="c-gray en">&gt;</span>
    <a href="#">系统管理</a>
    <span class="c-gray en">&gt;</span>
    <a href="">基本设置</a>
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class='page-container'>
<div style="background-color: #333;color: white;border: solid 1px #1295bf;font-size:12px;" id="testResult">

</div>

<form method="post" id="form1" >
    <table class="my-table-vertical">
        <tbody>
            <tr>
                <th style="width: 250px;">域名：</th>
                <td>
                    <select name="domainid" onchange="changeDomain(this.value)">
                    <?php
                    foreach ($domains as $oneDomain):
                    ?>
                    <option value="<?= $oneDomain->id ?>"  <?= $domainid == $oneDomain->id ? 'selected' : '' ?>  > <?= $oneDomain->domain ?> <?= $oneDomain->name ?>  </option>
                    <?php
                    endforeach;
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>采集网页名称：</th>
                <td>
                    <input type="text" name="name" style="width: 800px;"  />
                </td>
            </tr>
            <tr>
                <th>网页地址（网址）：</th>
                <td>
                    <input type="text" name="url" id="url"  style="width: 800px;" />
                </td>
            </tr>
            <tr>
                <th style="color: red;">[慎用]生产连页地址：</th>
                <td><select name="lianxuyema"><option value="0">否</option><option value="1">是</option></select></td>
            </tr>
            <tr>
                <th style="color: red;">页码地址：</th>
                <td><input type="text" name="yemadizhi" value="" placeholder="比如xxxx{page}.html" style="width: 800px;" /></td>
            </tr>
            <tr>
                <th style="color: red;">起始页码：</th>
                <td><input type="text" name="qishiyema" value="2"  style="width: 800px;" /></td>
            </tr>
            <tr>
                <th style="color: red;">结束页码：</th>
                <td><input type="text" name="jiesuyema" value="20"  style="width: 800px;" /></td>
            </tr>
            <tr>
                <th style="color: red;">网页编码：</th>
                <td>
                    <select name="pageencode">
                        <option value="UTF-8"  <?= $domain && $domain->pageencode == 'UTF-8' ? 'selected' : '' ?>  >UTF-8</option>
                        <option value="GB2312"  <?= $domain && $domain->pageencode == 'GB2312' ? 'selected' : '' ?>   >GB2312</option>
                        <option value="GBK"   <?= $domain && $domain->pageencode == 'GBK' ? 'selected' : '' ?>  >GBK</option>
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
                            <option value="<?= $oneExam->id ?>"  <?= $oneExam->id == ($exam ? $exam->id : $lastexamid) ? 'selected' : '' ?>  ><?= $oneExam->name ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                    <input type="text"  onkeyup="findArea($(this).val(),'examid')" style="width: 120px;" placeholder="搜索考试"/>
                </td>
            </tr>
            <tr>
                <th>合适的分类【仅供参考】：</th>
                <td>
                    <select  name="articlecategory">
                    <?php
                    foreach ($categories as $oneCategory):
                    ?>
                    <option value="<?= $oneCategory->id ?>"><?= $oneCategory->text ?></option>
                    <?php
                    endforeach;
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>资讯链接selector：</th>
                <td>
                    <input type="text" name="xpath_a" id="xpath_a" value="<?= $domain ? $domain->xpath_a : '' ?>" style="width: 800px;"  />
                </td>
            </tr>
            <tr>
                <th>第几个A标签：</th>
                <td>
                    <input type="text" name="linkindex" id="linkindex" value="0" style="width: 100px;"  /> [资讯链接selector无法直接获取a标签时候，采用资讯链接selector的上一级同时使用simple_dom_html进行a标签获取]
                </td>
            </tr>
            <tr>
                <th>资讯内容selector：</th>
                <td>
                    <input type="text" name="xpath_content" id="xpath_content" value="<?= $domain ?  $domain->xpath_content  : ''?>" style="width: 800px;"  />
                </td>
            </tr>
            <tr>
                <th>资讯内容翻页selector：</th>
                <td>
                    <input type="text" name="xpath_content_path"  id="xpath_content_path" placeholder="没有可不填" value="<?= $domain ?  $domain->xpath_content_path : '' ?>" style="width: 800px;"  />
                </td>
            </tr>
            <tr>
                <th>启用：</th>
                <td>
                    <select name="enable">
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>任务开始时间：</th>
                <td>
                    <input type="text" name="starttime" value="2010-01-01 01:01:01"  placeholder="表示该执行列表该指定的任务时间内可以对其进行任务执行操作" style="width: 800px;" />
                </td>
            </tr>
            <tr>
                <th>任务结束时间：</th>
                <td>
                    <input type="text" name="endtime" value="2055-05-05 05:00:05" placeholder="表示该执行列表该指定的任务时间内可以对其进行任务执行操作" style="width: 800px;" />
                </td>
            </tr>

        </tbody>
    </table>
    <div class="fixed-bottom-btn">
        <input type="submit" class="btn btn-success" value="提交" />
        <input type="button" class="btn btn-warning" value="测试" onclick="test()"/>
    </div>
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