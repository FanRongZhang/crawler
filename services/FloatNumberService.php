<?php
namespace app\services;

/**
 * 进行数据之间的运算
 * 针对多次+-x/后的最终结果可进行toRound
 * @package app\services
 */
class FloatNumberService{


    public static function toRound($final_numeric, $precision = 2){
        return round($final_numeric, $precision);
    }

    public static function add($left,$right,$scale=6){
        bcscale($scale);
        return bcadd($left,$right);
    }

    public static function sub($left,$right,$scale=6){
        bcscale($scale);
        return bcsub($left,$right,$scale);
    }

    public static function mul($left,$right,$scale=6){
        bcscale($scale);
        return bcmul($left,$right,$scale);
    }

    public static function div($left,$right,$scale=6){
        bcscale($scale);
        return bcdiv($left,$right,$scale);
    }
}
