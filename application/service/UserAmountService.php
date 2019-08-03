<?php
/**
 * Created by PhpStorm.
 * User: yjl
 * Date: 2019/8/3
 * Time: 16:51
 */

namespace app\service;
use think\Db;

/**
 * 充值服务层
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class UserAmountService
{
    /**
     * @param $user_id  [用户id]
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function UserInfo($user_id){
        $user=Db::name('UserAmount')->where(['userid' => $user_id])->find();
        return $user;
    }

    /**
     * @param $user_id          [用户id]
     * @param string $column    [要查询的字段]
     * @return mixed
     */
    public static function UserIntegal($user_id,$column=''){
        $col=Db::name('UserAmount')->where(['userid' => $user_id])->value($column);
        return $col;
    }
    /**
     * @param $user_id
     * @param $amount
     * @param $orderno
     * @param int $flowtype
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function  UserBdAmountAdd($user_id,$amount,$orderno,$flowtype=11)
    {
        $user=self::UserInfo($user_id);
        if($user){
            // 开启事务
            Db::startTrans();
            $bd_amount=self::UserIntegal($user_id,'bdamount');
            $data = array(
                'userid'           => intval($user_id),
                'flowid'            =>'BD' . $orderno. rand(100000, 9999999),
                'usertype'          =>1,
                'userid'            =>$user_id,
                'orderno'           =>$orderno,
                'flowtype'          =>$flowtype,
                'direction'         =>1,
                'amount'            =>$amount,
                'final_amount'      =>$bd_amount+$amount,
                'beforeamount'      =>$bd_amount,
                'afteramount'       =>$bd_amount+$amount,
                'flowtime'          =>date("Y-m-d H:i:s"),
            );
            if(Db::name('FlowBdAmount')->insertGetId($data) > 0){
                Db::name('UserAmount')->where(['userid' => $user_id])->setInc('bdamount',$amount);
                // 提交事务
                Db::commit();
                return true;
            }else{
                // 回滚事务
                Db::rollback();
                return false;
            }

        }
    }

    /**
     * @param $user_id
     * @param $amount
     * @param $orderno
     * @param int $flowtype
     * @return array|bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function UserBdAmountRec($user_id,$amount,$orderno,$flowtype=12)
    {
        $user=self::UserInfo($user_id);
        if($user){
            // 开启事务
            Db::startTrans();
            $bd_amount=self::UserIntegal($user_id,'bdamount');
            if($bd_amount<$amount){
                return DataReturn('报单币余额不足', 0);
            }
            $data = array(
                'userid'           => intval($user_id),
                'flowid'            =>'BD' . $orderno. rand(100000, 9999999),
                'usertype'          =>1,
                'userid'            =>$user_id,
                'orderno'           =>$orderno,
                'flowtype'          =>$flowtype,
                'direction'         =>2,
                'amount'            =>$amount,
                'final_amount'      =>$bd_amount-$amount,
                'beforeamount'      =>$bd_amount,
                'afteramount'       =>$bd_amount-$amount,
                'flowtime'          =>date("Y-m-d H:i:s"),
            );
            if(Db::name('FlowBdAmount')->insertGetId($data) > 0){
                Db::name('UserAmount')->where(['userid' => $user_id])->setDec('bdamount',$amount);
                // 提交事务
                Db::commit();
                return true;
            }else{
                // 回滚事务
                Db::rollback();
                return false;
            }

        }
    }
}