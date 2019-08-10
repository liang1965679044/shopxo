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

    /**积分兑换现金
     * @param $score
     * @param $userid
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function Userechange($score,$userid)
    {

        if(!is_numeric($score)){
            return DataReturn('输入积分有误',-1);
        }
        if (!is_int($score + 0) || ($score + 0) < 0) {
            return DataReturn('输入积分只能是正整数',-1);
        }
        $jf=UserAmountService::UserInfo($userid);
        if(empty($jf['jfamount']) || $score>$jf['jfamount']){
            return DataReturn('积分不足，兑换失败',-1);
        }

        UserAmountService::UserJfAmountRec($userid,$score,StrOrderOne());
        UserAmountService::UserJjAmountAdd($userid,$score*0.7,StrOrderOne());
        $res=UserAmountService::UserJfbAmountAdd($userid,$score*0.3,StrOrderOne());
        if($res){
            return DataReturn('兑换成功', 0);
        }
        return DataReturn('系统异常,兑换失败', 0);
    }

    /**股权兑换原始股
     * @param $gq
     * @param $userid
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function Gqchange($gq,$userid){
        if(!is_numeric($gq)){
            return DataReturn('输入股权有误',-1);
        }
        if (!is_int($gq + 0) || ($gq + 0) < 0) {
            return DataReturn('输入股权只能是正整数',-1);
        }
        $jf=UserAmountService::UserInfo($userid);
        if(empty($jf['guquanamount']) || $gq>$jf['guquanamount']){
            return DataReturn('股权不足，兑换失败',-1);
        }

        $res=UserAmountService::UserGqAmountRec($userid,$gq,StrOrderOne());
        if($res){
            return DataReturn('兑换成功', 0);
        }
        return DataReturn('系统异常,兑换失败', -1);
    }

    /**奖金币提现
     * @param $gq
     * @param $userid
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function Jjchange($jj,$userid){
        if(!is_numeric($jj)){
            return DataReturn('输入股权有误',-1);
        }
        if (!is_int($jj + 0) || ($jj + 0) < 0) {
            return DataReturn('输入股权只能是正整数',-1);
        }
        $jf=UserAmountService::UserInfo($userid);
        if(empty($jf['jjamount']) || $jj>$jf['jjamount']){
            return DataReturn('奖金币不足,提现失败',-1);
        }

        $res=UserAmountService::UserJjAmountRec($userid,$jj,StrOrderOne(),21);
        if($res){
            return DataReturn('提现成功', 0);
        }
        return DataReturn('系统异常,提现失败',-1);
    }
}