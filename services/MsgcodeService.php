<?php
namespace app\services;

/**
 * 返回的消息码
 * @package app\services
 */
class MsgcodeService{

    const OP_SUCCESS = 0;	// 操作成功
    const OP_FAILRE = 1;	// 操作失败

    const ERROR_SIGN = 2;   //签名错误
    const ERROR_PARAM = 3; // 参数错误


    const USER_EXISTS = 4;

    const NEED_LOGIN = 5;

    const NOT_BOUGHT_OR_FREE = 6;

    const PWD_USERNAME_NOT_CORRECT = 7;

    const VALICODE_NOT_CORRECT = 8;

    const BANED = 9;

    const NO_PWD_AND_USERNAME = 10;

    const USER_NOT_EXISTS = 11;

    const TOO_MUCH_SMS = 12;

    const VERIFY_PHONE = 13;

    const IS_NOT_VIP = 14;

    const TEL_EXISTS = 15;

    const NOT_READY_PLAY_TIME = 16;

    const IS_THERE_NOT_DONE_XCX_KECHENG = 17;

    const HAD_ATTENDED_TODAY = 50;

    const ALREADY_ENROLL = 80;

    const NOT_SUFFICIENT_FUNDS = 81;

    const TRANS_CODE_NOT_COMPLETE = 82;

    const ROOM_PWD_NOT_CORRECT = 83;

    const ROOM_PEOPLE_FULL = 84;

    const ROOM_PEOPLE_NOT_RIGHT = 85;

    const ROOM_ROLE_IS_DONE = 86;

    const ROOM_PEOPLE_NUMBER_NOT_CORRECT = 87;

    const NO_AVAILABLE_TIMU = 88;

    const SIGN_EXPIRE = 89;

    const NO_SIGN = 90;

    const SIGN_INVALID = 91;

    const YAN_LIAN_IS_DONE = 99;

    const NOT_THE_ROOM_USER = 100;

    const YAN_LIAN_HAD_START = 101;

    const TOO_FREQUENTLY = 102;

    private static $COMMON_RET = [
        self::OP_SUCCESS => '操作成功',
        self::OP_FAILRE => '操作失败',
        self::SIGN_EXPIRE => '签名过期',
        self::NO_SIGN => '缺少签名',
        self::SIGN_INVALID => '签名无效',

        self::ERROR_SIGN => '签名不对',
        self::ERROR_PARAM => '参数不对',

        self::USER_EXISTS => '用户已经存在',

        self::NEED_LOGIN => '需要登录',

        self::NOT_BOUGHT_OR_FREE => '未购买或者非免费',

        self::PWD_USERNAME_NOT_CORRECT => '用户名或者密码错误',

        self::VALICODE_NOT_CORRECT => '验证码不对或者已过期',

        self::BANED => '已被禁止',

        self::NO_PWD_AND_USERNAME => '请先输入用户名或密码',

        self::USER_NOT_EXISTS => '用户不存在',

        self::TOO_MUCH_SMS => '发送短信次数过多，请稍后再试',

        self::VERIFY_PHONE => '请先验证手机',

        self::IS_NOT_VIP => '不是VIP用户',

        self::TEL_EXISTS => '手机号已注册',

        self::NOT_READY_PLAY_TIME => '未到播放或直播时间',

        self::HAD_ATTENDED_TODAY => '今天已经签到过了',

        self::IS_THERE_NOT_DONE_XCX_KECHENG => '存在未完成的课程学习计划',

        self::ALREADY_ENROLL => '你已经报过名了',

        self::NOT_SUFFICIENT_FUNDS => '账户余额不足',

        self::TRANS_CODE_NOT_COMPLETE => '转码未完成',

        self::ROOM_PWD_NOT_CORRECT => '房间密码不对',

        self::ROOM_PEOPLE_FULL => '房间人数已满',

        self::ROOM_PEOPLE_NOT_RIGHT => '房间人数不对',

        self::ROOM_ROLE_IS_DONE => '角色分配已经全部结束',

        self::ROOM_PEOPLE_NUMBER_NOT_CORRECT => '房间人数不对或者不足导致无法提供正常服务',

        self::NO_AVAILABLE_TIMU => '无可用题目',

        self::YAN_LIAN_IS_DONE => '演练已经结束',

        self::NOT_THE_ROOM_USER => '不是该房间用户',

        self::YAN_LIAN_HAD_START => '演练已经开始',

        self::TOO_FREQUENTLY => '操作太频繁，请稍后再试',
    ];

    /**
     * 获取消息提示信息
     *
     * @param int $ret
     * @return string
     */
    public static function getRetMsg($ret){
        $msg = !empty(self::$COMMON_RET[$ret]) ? self::$COMMON_RET[$ret] : '';
        return $msg;
    }
}