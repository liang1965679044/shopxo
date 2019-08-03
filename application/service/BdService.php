<?php
/**
 * Created by PhpStorm.
 * User: yjl
 * Date: 2019/8/3
 * Time: 14:47
 */

namespace app\service;

use think\Db;
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
        if(!$amount){
            return DataReturn('报单币余额不足,请充值', 0);
        }
        if(empty($params['user']['address'])){
            return DataReturn('用户地址不能为空,报单失败', 0);
        }
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