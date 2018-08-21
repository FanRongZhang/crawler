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


    <?php
    $form = \yii\bootstrap\ActiveForm::begin();
    ?>


    <table class="table">
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
                <th>资讯链接selector：</th>
                <td>
                    <input type="text" name="selector_a" id="xpath_a" value="<?= $domain ? $domain->xpath_a : '' ?>" style="width: 800px;"  />
                </td>
            </tr>
            <tr>
                <th>第几个A标签：</th>
                <td>
                    <input type="text" name="linkindex"  value="0" style="width: 100px;"  /> [资讯链接selector无法直接获取a标签时候，采用资讯链接selector的上一级同时使用simple_dom_html进行a标签获取]
                </td>
            </tr>
            <tr>
                <th>资讯时间selector：</th>
                <td>
                    <input type="text" name="selector_time"   value="<?= $domain ?  $domain->selector_time  : ''?>" style="width: 800px;"  />
                </td>
            </tr>
            <tr>
                <th>资讯内容selector：</th>
                <td>
                    <input type="text" name="selector_content" value="<?= \yii\helpers\Html::encode($domain ?  $domain->selector_content  : '')?>" style="width: 800px;"  />
                </td>
            </tr>
            <tr>
                <th>资讯内容翻页selector：</th>
                <td>
                    <input type="text" name="selector_content_page_path"   placeholder="没有可不填" value="<?= \yii\helpers\Html::encode($domain ?  $domain->selector_content_page_path : '') ?>" style="width: 800px;"  />
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
                    <?= \nex\datepicker\DatePicker::widget([
                        'name' => 'starttime',
                        'value' => date('Y-m-d'),
                        'placeholder' => 'Choose date',
                        'clientOptions' => [
                            'format' => 'L',
                        ],
                    ]);?>
                </td>
            </tr>
            <tr>
                <th>任务结束时间：</th>
                <td>
                    <?= \nex\datepicker\DatePicker::widget([
                        'name' => 'endtime',
                        'value' => date('Y-m-d',strtotime('+1 year')),
                        'placeholder' => 'Choose date',
                        'clientOptions' => [
                            'format' => 'L',
                        ],
                    ]);?>
                </td>
            </tr>

        </tbody>
    </table>
    <div class="fixed-bottom-btn">
        <input type="submit" class="btn btn-success" value="提交" />
        <input type="button" class="btn btn-warning" value="测试" onclick="test()"/>
    </div>

    <?php
    \yii\bootstrap\ActiveForm::end();
    ?>