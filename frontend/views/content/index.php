<?php
/* @var $articles \common\models\Crawlerarticle[] */

$this->title = '综合信息';
?>


<style type="text/css">
    .infinite-scroll-preloader {
        margin-top:-20px;
    }
</style>
<!-- 添加 class infinite-scroll 和 data-distance  向下无限滚动可不加infinite-scroll-bottom类，这里加上是为了和下面的向上无限滚动区分-->
<div class="content infinite-scroll infinite-scroll-bottom" data-distance="100">
    <div class="list-block" style="margin-top:3px;">
        <ul class="list-container">
            <?php
            foreach ($articles as $one) {
                ?>
                <li class="item-content">
                    <div class="item-inner"><div class="item-title">
                        <a href="/content/article?id=<?= $one->id ?>">
                            <?= \yii\helpers\Html::encode($one->title) ?>
                            &nbsp; &nbsp;
                            <?= \yii\helpers\Html::encode(date('Y-m-d',$one->article_time)) ?>
                        </a>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <!-- 加载提示符 -->
    <div class="infinite-scroll-preloader">
        <div class="preloader"></div>
    </div>
</div>

<script>
    $.init();

    // 加载flag
    var loading = false;

    function addItems(data) {
        // 生成新条目的HTML
        var html = '';
        for(var i in data){
            var $a = '<a href="/content/article?id='+ data[i].id +'">'+ data[i].title + '&nbsp;&nbsp;' + data[i].article_time +'</a>';
            html += '<li class="item-content"><div class="item-inner"><div class="item-title">' + $a + '</div></div></li>';
        }
        if(html) {
            $('.infinite-scroll-bottom .list-container').append(html);
            //容器发生改变,如果是js滚动，需要刷新滚动
            $.refreshScroller();
        }
    }

    var pulldata = function () {
        console.log('pull data...');
        // 如果正在加载，则退出
        if (loading) return;

        // 设置flag
        loading = true;
        var offset = $('.list-container li').length;
        $.ajax({
            url:'/content/ajax-list?offset=' + offset,
            success:function (result) {
                loading = false;
                if(result.code != 0){
                    return;
                }
                var data = result.data;
                if(data == false){
                    // 加载完毕，则注销无限加载事件，以防不必要的加载
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    // 删除加载提示符
                    $('.infinite-scroll-preloader').remove();
                    return;
                }
                addItems(data);
            }
        });
    }


    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom',function() {
        pulldata();
    });
</script>