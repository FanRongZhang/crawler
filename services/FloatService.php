<?php
namespace app\services;

class FloatNumberService{
    /**
    加
     */
    public static function add($left,$right,$scale=2){
        return bcadd($left,$right,$scale);
    }

    /**
    减
     */
    public static function sub($left,$right,$scale=2){
        return bcsub($left,$right,$scale);
    }

    /**
    乘
     */
    public static function mul($left,$right,$scale=2){
        return bcmul($left,$right,$scale);
    }

    /**
    除
     */
    public static function div($left,$right,$scale=2){
        return bcdiv($left,$right,$scale);
    }
}