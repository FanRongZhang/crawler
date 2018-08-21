


<form method="post">
    <table class="table">
        <tbody>
            <tr>
                <th>名称</th>
                <td>
                    <input type="text" name="name" class="form-control"/>
                </td>
            </tr>
            <tr>
                <th>域名</th>
                <td>
                    <input type="text" name="domain" class="form-control"/>
                </td>
            </tr>
            <tr>
                <th>资讯链接selector：</th>
                <td>
                    <input type="text" name="selector_a"   class="form-control"/>
                </td>
            </tr>
            <tr>
                <th>资讯时间selector：</th>
                <td>
                    <input type="text" name="selector_time"    class="form-control"/>
                </td>
            </tr>
            <tr>
                <th>资讯内容selector：</th>
                <td>
                    <input type="text" name="selector_content"  class="form-control"/>
                </td>
            </tr>
            <tr>
                <th>资讯内容翻页selector：</th>
                <td>
                    <input type="text" name="selector_content_page_path"    placeholder="没有可不填"   class="form-control"/>
                </td>
            </tr>
            <tr>
                <th style="color: red;">网页编码：</th>
                <td>
                    <select name="pageencode">
                        <option value="UTF-8" >UTF-8</option>
                        <option value="GB2312" >GB2312</option>
                        <option value="GBK" >GBK</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>是否启用</th>
                <td>
                    <select name="enable">
                        <option value="1">是</option>
                        <option value="0">否</option>
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