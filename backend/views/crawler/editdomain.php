<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/31
 * Time: 16:35
 */
/* @var $domain common\models\Crawlerdomain */
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
<form method="post" >
    <table class="my-table-vertical">
        <tbody>
            <tr>
                <th>名称</th>
                <td>
                    <input type="text" name="name" value="<?= $domain->name ?>" />
                </td>
            </tr>
            <tr>
                <th>域名</th>
                <td>
                    <input type="text" name="domain" value="<?= $domain->domain ?>" />
                </td>
            </tr>
            <tr>
                <th>资讯链接selector：</th>
                <td>
                    <input type="text" name="xpath_a" id="xpath_a" value="<?= $domain->xpath_a ?>"  />
                </td>
            </tr>
            <tr>
                <th>资讯内容selector：</th>
                <td>
                    <input type="text" name="xpath_content" id="xpath_content" value="<?= $domain->xpath_content ?>"  />
                </td>
            </tr>
            <tr>
                <th>资讯内容翻页selector：</th>
                <td>
                    <input type="text" name="xpath_content_path"  id="xpath_content_path" placeholder="没有可不填"  value="<?= $domain->xpath_content_path ?>" />
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