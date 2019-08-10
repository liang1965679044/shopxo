<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2019 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;
use app\service\UserAmountService;

/**
 * 配置设置
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Stock extends Common
{
    /**
     * 构造方法
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-03T12:39:08+0800
     */
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();

        // 登录校验
        $this->IsLogin();

        // 权限校验
        $this->IsPower();
    }



    /**
     * 商店信息
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function Store()
    {
        // 配置信息
        $data = Db::name('SysConfig')->find();
        // 参数
        $this->assign('data', $data);

        return $this->fetch();
    }
    /**
     * 商店信息
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function change()
    {
        //
        $list=Db::name('SysConfig')->find();
        // 配置信息
        $data = Db::name('User')->select();
        // 参数
        $this->assign('data', $data);
        $this->assign('list', $list);
        return $this->fetch();
    }
    public function assign_gq(){
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        // 开始处理
        $params = input();
        if(empty($params['userid'])){
            return DataReturn('用户状态异常,分配失败',-1);
        }
        if(!is_numeric($params['value'])){
            return DataReturn('输入原始股有误',-1);
        }
        if (!is_int($params['value'] + 0) || ($params['value'] + 0) < 0) {
            return DataReturn('输入原始股只能是正整数',-1);
        }
        // 开启事务
        Db::startTrans();
        $res=Db::name('SysConfig')->where(['id' => 1])->setDec('value',$params['value']);
        if($res){
            $orderno=StrOrderOne();
            $yes=UserAmountService::UserGqAmountAdd($params['userid'],$params['value'],$orderno);
            if($yes){
                Db::commit();
                return DataReturn('股权分配成功',0);
            }else{
                // 回滚事务
                Db::rollback();
            }
        }
        return DataReturn('原始股权分配失败,系统异常',-1);
    }
    /**
     * 配置数据保存
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2017-01-02T23:08:19+0800
     */
    public function Save()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        // 开始处理
        $params = input();
        if(!is_numeric($params['value'])){
            return DataReturn('输入原始股有误');
        }

        if (!is_int($params['value'] + 0) || ($params['value'] + 0) < 0) {
            return DataReturn('输入原始股只能是正整数');
        }
        $data = array(
            'zname'              =>  $params['zname'],
            'value'              =>  $params['value'],

        );
        $res=Db::name('SysConfig')->where(['id' => 1])->update($data);
        if($res){
            return  DataReturn('配置成功', 0);
        }
        return  DataReturn('配置失败', -1);
    }

}
?>