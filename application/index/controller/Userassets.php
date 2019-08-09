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

use think\Db;
use app\service\AssetsService;
use app\service\UserLevelService;

/**
 * 用户资产管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class UserAssets extends Common
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
     * 用户资产列表
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-28
     * @desc    description
     */
    public function Index()
    {
        $data=AssetsService::Index($this->user['id']);
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**用户资产详细
     * @return array|\PDOStatement|string|\think\Model|null
     */
    public function amount()
    {
        $data=AssetsService::Index($this->user['id']);
        return $data;
    }

    /**报单币
     * @return mixed
     */
    public function bd(){
        // 参数
        $params = input();
        $params['user'] = $this->user;
        // 分页
        $number = 10;
        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 获取总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowBdAmount');
        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('index/userassets/bd'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = AssetsService::UserAssetsLogList($data_params,'FlowBdAmount');
        $this->assign('data_list', $data['data']);

        // 操作类型
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));
        //金额
        $amount=$this->amount();
        $this->assign('amount', $amount);
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }
    /**奖金币
     * @return mixed
     */
    public function jj(){
        // 参数
        $params = input();
        $params['user'] = $this->user;
        // 分页
        $number = 10;
        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 获取总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowJjAmount');
        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('index/userassets/jj'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = AssetsService::UserAssetsLogList($data_params,'FlowJjAmount');
        $this->assign('data_list', $data['data']);

        // 操作类型
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));
        //金额
        $amount=$this->amount();
        $this->assign('amount', $amount);
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }
    /**积分币
     * @return mixed
     */
    public function jfb(){
        // 参数
        $params = input();
        $params['user'] = $this->user;
        // 分页
        $number = 10;
        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 获取总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowJfbAmount');
        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('index/userassets/jfb'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = AssetsService::UserAssetsLogList($data_params,'FlowJfbAmount');
        $this->assign('data_list', $data['data']);

        // 操作类型
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));
        //金额
        $amount=$this->amount();
        $this->assign('amount', $amount);
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }
    /**积分
     * @return mixed
     */
    public function jf(){
        // 参数
        $params = input();
        $params['user'] = $this->user;
        // 分页
        $number = 10;
        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 获取总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowJfAmount');
        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('index/userassets/jf'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = AssetsService::UserAssetsLogList($data_params,'FlowJfAmount');
        $this->assign('data_list', $data['data']);

        // 操作类型
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));
        //金额
        $amount=$this->amount();
        $this->assign('amount', $amount);
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }
    /**股权
     * @return mixed
     */
    public function gq(){
        // 参数
        $params = input();
        $params['user'] = $this->user;
        // 分页
        $number = 10;
        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 获取总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowGqAmount');
        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('index/userassets/gq'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = AssetsService::UserAssetsLogList($data_params,'FlowGqAmount');
        $this->assign('data_list', $data['data']);

        // 操作类型
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));
        //金额
        $amount=$this->amount();
        $this->assign('amount', $amount);
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
     * @return mixed
     */
    public function bd_info(){
        return $this->fetch();
    }

    /**
     * @return mixed
     */
    public function jj_info(){
        return $this->fetch();
    }

    /**
     * @return mixed
     */
    public function jf_info(){
        return $this->fetch();
    }

    /**
     *
     */
    public function jf_change(){

        $params = input();
        return UserLevelService::Userexchange($params['money'],$this->user['id']);
    }

    /**
     * @return mixed
     */
    public function gq_info(){
        return $this->fetch();
    }
    /**
     * @return mixed
     */
    public function gq_change(){
        $params = input();
        return UserLevelService::Userexchange($params['money'],$this->user['id']);
    }

}
?>