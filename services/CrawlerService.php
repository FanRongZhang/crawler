<?php
namespace app\services;

use common\models\Crawlerarticle;
use common\models\Crawlerarticlelistpage;
use common\models\Msgnoticeforbackenduser;
use QL\QueryList;
use yii\helpers\ArrayHelper;

require_once "simple_html_dom.php";

class CrawlerService
{

    /**
     * 处理进程数
     */
    const PROCESSES_COUNT = 4;

    /**
     * 设置 发生了异常的列表页 重新为正常状态
     * 比如 因为政府网站自身发生 500 错误代码
     */
    public static function restoreToNormal(){
        //将发生CURL错误的全部恢复为正常
        while($list = Crawlerarticlelistpage::find()->where(['like','unnormal_system_mark','cURL'])->andWhere('is_normal=0')->limit(100)->all()){
            foreach ($list as $one){
                $one->is_normal = 1;
                $one->unnormal_system_mark = '';
                $one->save();
            }
        }
    }


    /**
     * 抓取指定的列表页
     * @param Crawlerarticlelistpage $listpage
     * @param bool $forDb
     * @return array
     */
    public static function crawl(Crawlerarticlelistpage $listpage,$forDb = true)
    {
        try {
            $url = $listpage->url;
            $xpath_a = $listpage->selector_a;//列表页咨询链接
            $xpath_time = $listpage->selector_time;//列表页资讯时间
            $xpath_content = $listpage->selector_content;//内容页 content path
            $xpath_content_page_path = $listpage->selector_content_page_path; // 内容页 翻页 path

            if($forDb) {
                $listpage->start_working_time_last_time = time();
                $listpage->working_status = 1;
                $listpage->save();
            }

            $ql = QueryList::get($url);
            if($listpage->pageencode != 'UTF-8') {
                $ql->encoding('UTF-8', $listpage->pageencode);
            }

            if($ql->getHtml() == false){
                return [];
            }

            //file_put_contents('h', $ql->getHtml());

            //collect the title and link info
            $aryEveryLinkContent = $ql->rules([
                'title' => [$xpath_a, 'text'],
                'link' => [$xpath_a, 'href'],
                'article_time' => [$xpath_time, 'text'],
            ])->query()->getData()->all();

            //如果未找到采用HTML SELECTOR兼容性更高的SIMPLEHTML
            if( !$aryEveryLinkContent ) {
                $simple_html_dom = str_get_html($ql->getHtml());
                if(!$simple_html_dom){
                    return [];
                }
                $aryLinksDom = $simple_html_dom->find($xpath_a);
                if ($aryLinksDom) {
                    foreach ($aryLinksDom as $oneDom) {
                        $targetA = $oneDom->find("a[href]", $listpage->linkindex);
                        if($targetA) {
                            $aryEveryLinkContent[] = [
                                'title' => $targetA->plaintext,
                                'link' => $targetA->href
                            ];
                        }
                    }
                }
            }
            //end collect of the title and link info

            //读取title link 后读取 内容
            foreach ($aryEveryLinkContent as &$oneLinkContent) {
                $aryContent = [];
                $targetUrl = UrlQueryService::formatUrl($oneLinkContent['link'], $url);

                if($forDb){
                    $crawler = Crawlerarticle::find()->limit(1)->where([
                        //'listpageid' => $listpage->id,
                        'url' => $targetUrl
                    ])->one();
                    //最大抓取策略
                    //同时为了执行效率和确保不遗漏每个链接 综合考虑，如果该网页已经存在，则不抓取了进行跳过
                    if($crawler){
                        continue;
                    }
                }

                $ql = QueryList::get($targetUrl);
                if($listpage->pageencode != 'UTF-8') {
                    $ql->encoding('UTF-8', $listpage->pageencode);
                }

                $contentHtml =  $ql->find($xpath_content)->html();

                //simple dom
                if(!$contentHtml) {
                    $simple_html_dom = str_get_html($ql->getHtml());
                    if($simple_html_dom){
                        $contenDom = $simple_html_dom->find($xpath_content, 0);
                        if($contenDom) {
                            $contentHtml = $contenDom->innertext;
                        }
                    }
                }

                if(!$contentHtml){
                    $contentHtml = '';
                }

                //存放内容
                $aryContent[] = HtmlFormatService::clearHtmlStyle($contentHtml);


                //如果存在内容分页
                if($xpath_content_page_path) {
                    $ql->find($xpath_content_page_path)->map(function ($contentLink) use ($aryContent, $xpath_content) {
                        if ($contentLink->is('a') && is_numeric($contentLink->text()) && intval($contentLink->text()) > 1) {
                            $aryContent[] = HtmlFormatService::clearHtmlStyle(QueryList::get($contentLink->attr('href'))->find($xpath_content)->html());
                        }
                    });
                }

                $oneLinkContent['domainid'] = $listpage->domainid;
                $oneLinkContent['content_type'] = $listpage->content_type;
                $oneLinkContent['listpageid'] = $listpage->id;
                $oneLinkContent['url'] = $targetUrl;
                try {
                    $oneLinkContent['keyword'] = $ql->find('meta[name=keywords]')->content; //The page keywords
                    $oneLinkContent['description'] = $ql->find('meta[name=description]')->content; //The page keywords
                } catch (\Exception $ep) {
                    //do nothing,skip it
                }catch (\Throwable $a){
                    //ignore it
                }

                //将DOC PDF等文件的下载地址更换
                /*
                if ($forDb) {
                    $contentForDB = implode('_ueditor_page_break_tag_', $aryContent);
                    $aryUrls = UrlQueryService::getUrlByHtml($contentForDB, $targetUrl, true);
                    try {
                        foreach ($aryUrls as $rawUrl => $downUrl) {
                            $ext = pathinfo($downUrl, PATHINFO_EXTENSION);
                            if (in_array($ext, ['doc', 'xls', 'docx', 'pdf', 'rar', 'zip'])) {
                                $key = 'attach/' . md5($downUrl . time() . str_shuffle('abcdefghijklmnoprqstx901292819904523671')) . '.' . $ext;
                                QiniuService::getQiNiu()->uploadByUrl($downUrl, $key);
                                $contentForDB = str_replace($rawUrl, QiniuService::getFileOrigin($key), $contentForDB);
                            }
                        }
                    }catch (\Exception $eepp){
                        //ignore download & upload error
                    }
                    $oneLinkContent['content'] = $contentForDB;
                } else {
                    $oneLinkContent['content'] = implode('<hr>', $aryContent);
                }
                */

                $oneLinkContent['content'] = implode('<hr>', $aryContent);
                $oneLinkContent['article_time'] = is_int($oneLinkContent['article_time']) ? $oneLinkContent['article_time'] : strtotime($oneLinkContent['article_time']);
                $oneLinkContent['is_public'] = 1;
                $oneLinkContent['is_deleted'] = 0;
                $oneLinkContent['createtime'] = time();

                if($forDb){
                    $crawler = new Crawlerarticle();
                    $crawler->setAttributes($oneLinkContent,false);
                    $crawler->save();
                    sleep(1);//保存一个资讯后休息几秒
                }
            }

            if($forDb) {
                $listpage->end_working_time_last_time = time();
                $listpage->working_status = 0;
                $listpage->save();
            }

            return $aryEveryLinkContent;
        }catch (\Exception $e) {
            if($listpage->id) {
                $listpage->end_working_time_last_time = time();
                $listpage->working_status = 0;
                $listpage->is_normal = 0;
                $listpage->unnormal_system_mark = " msg: ".mb_substr($e->getTraceAsString(),0,500)." file: {$e->getFile()} line: {$e->getLine()} code: {$e->getCode()} ";
                $listpage->save();
            }
            return [];
        }
    }
}