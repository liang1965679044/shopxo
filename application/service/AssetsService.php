<?php
/**
 * Created by PhpStorm.
 * User: yjl
 * Date: 2019/8/3
 * Time: 11:00
 */

namespace app\service;
use think\Db;


/**
 * 资产服务层
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class AssetsService
{
    public static function Index($userid){
        $where = array('userid' => $userid);
        $data=Db::name('UserAmount')->where($where)->find();
        return $data;
    }
    /**
     * 前端报单币列表条件
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-29
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function UserAssetsLogListWhere($params = [])
    {
        // 条件初始化
        $where = [];

        // 用户id
        if(!empty($params['user']))
        {
            $where[] = ['userid', '=', $params['user']['id']];
        }

        // 是否更多条件
        if(isset($params['is_more']) && $params['is_more'] == 1)
        {
            if(isset($params['type']) && $params['type'] > -1)
            {
                $where[] = ['direction', '=', intval($params['type'])];
            }
            // 时间
            if(!empty($params['time_start']))
            {
                $where[] = ['flowtime', '>=', strtotime($params['time_start']. '00:00:00')];
            }
            if(!empty($params['time_end']))
            {
                $where[] = ['flowtime', '<=', strtotime($params['time_end'].' 23:59:59')];
            }
        }
        return $where;
    }
    /**
     * 用户报单币日志总数
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-29
     * @desc    description
     * @param   [array]          $where [条件]
     */
    public static function UserAssetsLogTotal($where = [],$db='FlowBdAmount')
    {
        return (int) Db::name($db)->where($where)->count();
    }
    /**
     * 报单币日志列表
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-29
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function UserAssetsLogList($params = [],$db='FlowBdAmount')
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;
        $order_by = empty($params['order_by']) ? 'id desc' : $params['order_by'];
        // 获取数据列表
        $data = Db::name($db)->where($where)->limit($m, $n)->order($order_by)->select();
        if(!empty($data))
        {
            $common_bd_log_type_list = lang('common_bd_log_type_list');
            foreach($data as &$v)
            {
                // 操作类型
                $v['type_name'] = $common_bd_log_type_list[$v['direction']]['name'];
                // 时间
                $v['add_time_time'] = date('Y-m-d H:i:s', $v['flowtime']);
                $v['add_time_date'] = date('Y-m-d', $v['flowtime']);
            }
        }
        return DataReturn('处理成功', 0, $data);
    }
}