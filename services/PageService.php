<?php
namespace app\services;

use yii\data\Pagination;
use yii\db\ActiveQuery;

class PageService
{
    /**
     * 返回ar[]数组和分页对象
     * @param ActiveQuery $query
     * @param number $page
     * @param number $pageSize
     * @param string $asArray
     * @return \yii\data\Pagination[]|array[]|\yii\db\ActiveRecord[][]
     */
    public static function getPageData(ActiveQuery $query, $page = 1, $pageSize = 20, $asArray = false)
    {
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => $pageSize
        ]);
        $data = $query->offset(($page - 1) * $pageSize)->limit($pagination->limit)->asArray($asArray)->all();
        return [
            'list' => $data,
            'pages' => $pagination
        ];
    }


    public static function getPagination($count, $pageSize){
        return new Pagination([
                'totalCount' => $count,
                'pageSize' => $pageSize
            ]);
    }

}