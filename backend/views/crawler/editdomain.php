<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/31
 * Time: 16:35
 */
/* @var $domain common\models\Crawlerdomain */
?>


<form method="post" >
    <table class="table"">
        <tbody>
            <tr>
                <th>名称</th>
                <td>
                    <input type="text" name="name" value="<?= $domain->name ?>"  class="form-control"/>
                </td>
            </tr>
            <tr>
                <th>域名</th>
                <td>
                    <input type="text" name="domain" value="<?= $domain->domain ?>"  class="form-control" />
                </td>
            </tr>
            <tr>
                <th>资讯链接selector：</th>
                <td>
                    <input type="text" name="selector_a"  value="<?= $domain->selector_a ?>"  class="form-control"  />
                </td>
            </tr>
            <tr>
                <th>资讯链接时间：</th>
                <td>
                    <input type="text" name="selector_time"   value="<?= $domain->selector_time ?>"   class="form-control" />
                </td>
            </tr>
            <tr>
                <th>资讯内容selector：</th>
                <td>
                    <input type="text" name="selector_content"   value="<?= \yii\helpers\Html::encode($domain->selector_content) ?>"  class="form-control"  />
                </td>
            </tr>
            <tr>
                <th>资讯内容翻页selector：</th>
                <td>
                    <input type="text" name="selector_content_page_path"  placeholder="没有可不填"  value="<?= $domain->selector_content_page_path ?>"  class="form-control" />
                </td>
            </tr>
            <tr>
                <th style="color: red;">网页编码：</th>
                <td>
                    <select name="pageencode">
                        <option value="UTF-8"    <?= $domain->pageencode == 'UTF-8' ? 'selected' : '' ?>    >UTF-8</option>
                        <option value="GB2312"   <?= $domain->pageencode == 'GB2312' ? 'selected' : '' ?>   >GB2312</option>
                        <option value="GBK"    <?= $domain->pageencode == 'GBK' ? 'selected' : '' ?>  >GBK</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>是否启用</th>
                <td>
                    <select name="enable">
                        <option value="1" <?= $domain->enable == 1 ? 'selected' : '' ?> >是</option>
                        <option value="0" <?= $domain->enable == 0 ? 'selected' : '' ?> >否</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"  >
                    <input class="btn btn-success" type="submit" value="提交"/>
                </td>
            </tr>
        </tbody>
    </table>
</form>