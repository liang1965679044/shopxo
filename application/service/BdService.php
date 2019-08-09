<?php
/**
 * Created by PhpStorm.
 * User: yjl
 * Date: 2019/8/3
 * Time: 14:47
 */

namespace app\service;

use think\Db;
use app\service\UserService;
use app\service\UserAmountService;
class BdService
{
    /**
     * 返回报单套餐列表
     */
    public static function BdGoodsList()
    {
        // 获取数据列表
        $data = Db::name('BdGoods')->select();
        return DataReturn('查询成功', 0, $data);
    }

    /**
     * 开始报单
     *
     */
    public static function BdGoodsStart($params = [])
    {
        $amount=BdService::BdAmount($params['user']['id']);
        if($amount['bdamount']<0 || $amount['bdamount']<$params['goods_price']){
            return DataReturn('报单币余额不足,请充值', -1);
        }
        $address=UserService::UserAddressList($params);
        if(empty($address['data'])){
            return DataReturn('用户地址不能为空,报单失败', -1);
        }
        $res=UserAmountService::UserBdAmountRec($params['user']['id'],$params['goods_price'],StrOrderOne());
        if($res){
            return DataReturn('报单成功', 0);
        }
        return DataReturn('系统异常,报单失败', -1);
    }

    /**报单币余额
     * @param $userid
     * @return array|bool|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function BdAmount($userid)
    {
        if(empty($userid)){
            return false;
        }
        $where = array('userid' => $userid);
        $data=Db::name('UserAmount')->field('bdamount')->where($where)->find();
        return $data;
    }
}