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
namespace app\index\controller;

use app\service\BdService;
use app\service\UserAmountService;

use app\service\UserLevelService;

/**
 * 用户报单
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class UserBd extends Common
{
    /**
     * [_initialize 前置操作-继承公共前置方法]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-03T12:39:08+0800
     */
    public function _initialize()
    {
        // 调用父类前置方法
        parent::_initialize();

        // 是否登录
        $this->IsLogin();
    }

    /**
     * 报单套餐列表
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-28
     * @desc    description
     */
    public function Index()
    {
        $data = BdService::BdGoodsList();
        $this->assign('data_list', $data['data']);
        return $this->fetch();
    }

    /**
     *我要报单
     */
    public function StartBd()
    {

        $res=UserLevelService::Userexchange(99,$this->user['id']);
        dump($res);
       /* if(input())
        {
            $params = input();
            $params['user'] = $this->user;
            $res=BdService::BdGoodsStart($params);
        }else{
            return DataReturn('数据提交非法', 0);
        }
        return $this->error($res['msg']);*/
    }
}
