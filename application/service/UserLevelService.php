<?php
/**
 * Created by PhpStorm.
 * User: yjl
 * Date: 2019/8/4
 * Time: 21:01
 */

namespace app\service;

use think\Db;
use app\service\UserAmountService;
class UserLevelService
{
    const Promoter = 1380;          //推广员
    const Ordinary = 100000;         //普通代理
    const Area = 300000;             //区级代理
    const City = 1000000;             //市级代理
    const Provide = 5000000;          //省级代理

    //提成奖励
    const Royalty = [
        self::Promoter      => 0,
        self::Ordinary      => 0.15,
        self::Area          => 0.2,
        self::City          => 0.25,
        self::Provide       => 0.3,
    ];
    //用户等级列表
    const UserLevelList = [
        self::Promoter      => 1,
        self::Ordinary      => 2,
        self::Area          => 3,
        self::City          => 4,
        self::Provide       => 5,
    ];

    /**
     * @param $userid
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function UserLevelUp($userid)
    {
        $amount=UserAmountService::UserAmount($userid);
        if($amount>=self::Promoter){
            //升级为推广员
            $id=self::UserLevel(self::UserLevelList[1380]);
            self::Level($userid,$id);
        }
        if($amount>=self::Ordinary){
            //升级为普通代理
            $id=self::UserLevel(self::UserLevelList[100000]);
            self::Level($userid,$id);
        }
        if($amount>=self::Area){
            //升级为区级代理
            $id=self::UserLevel(self::UserLevelList[300000]);
            self::Level($userid,$id);
        }
        if($amount>=self::City){
            //升级为市级代理
            $id=self::UserLevel(self::UserLevelList[1000000]);
            self::Level($userid,$id);
        }
        if($amount>=self::Provide){
            //升级为省级代理
            $id=self::UserLevel(self::UserLevelList[5000000]);
            self::Level($userid,$id);
        }
        return true;
    }

    /**
     *找到用户所属角色的id
     */
    public static function UserLevel($level){
        $id= Db::name('UserLevel')->where(['level'=>$level])->value('id');
        return $id;
    }

    /**用户升级
     * @param $userid
     * @param int $level
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function Level($userid,$level=0)
    {
        $id= Db::name('User')->where(['id'=>$userid])->value('id');
        if($id){
            $data = [
                'userlevel'      => $level,
                'upd_time'       =>time(),
            ];
            Db::name('User')->where(['id'=>$id])->update($data);
        }
    }
    public static function UserScore($userid)
    {
        $jf= Db::name('UserAmount')->where(['userid'=>$userid])->value('jfamount');
        return $jf;
    }
    public static function Userexchange($score,$userid)
    {
        if(!is_numeric($score)){
            return DataReturn('输入积分有误');
        }

        if (!is_int($score + 0) || ($score + 0) < 0) {
            return DataReturn('输入积分只能是正整数');
        }
        $jf=self::UserScore($userid);
        if(empty($jf) || $score>$jf){
            return DataReturn('积分不足，兑换失败');
        }

        UserAmountService::UserJfAmountRec($userid,$score,'88888');
        UserAmountService::UserJjAmountAdd($userid,$score*0.7,'33242');
        UserAmountService::UserJfbAmountAdd($userid,$score*0.3,'882342342888');
        return DataReturn('兑换成功', 0);
    }
}