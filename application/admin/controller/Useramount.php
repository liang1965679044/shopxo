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
use app\service\AssetsService;

/**
 * 问答管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Useramount extends Common
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
     * 后台报单币列表
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function bd()
    {

        // 参数
        $params = input();

        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 总数
        $total = AssetsService::UserAssetsLogTotal($where);

        // 分页
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/useramount/bd'),
        );
        $page = new \base\Page($page_params);

        // 获取管理员列表
        $data_params = [
            'where'		=> $where,
            'm'			=> $page->GetPageStarNumber(),
            'n'			=> $number,
        ];
        $data = AssetsService::UserAssetsLogList($data_params);
        // 用户状态
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));

        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data_list', $data['data']);
        return $this->fetch();
    }
    /**
     * 后台奖金币列表
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function jj()
    {

        // 参数
        $params = input();

        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowJjAmount');

        // 分页
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/useramount/jj'),
        );
        $page = new \base\Page($page_params);

        // 获取管理员列表
        $data_params = [
            'where'		=> $where,
            'm'			=> $page->GetPageStarNumber(),
            'n'			=> $number,
        ];
        $data = AssetsService::UserAssetsLogList($data_params,'FlowJjAmount');
        // 用户状态
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));

        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data_list', $data['data']);
        return $this->fetch();
    }
    /**
     * 后台积分币列表
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function jfb()
    {

        // 参数
        $params = input();

        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowJfbAmount');

        // 分页
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/useramount/jfb'),
        );
        $page = new \base\Page($page_params);

        // 获取管理员列表
        $data_params = [
            'where'		=> $where,
            'm'			=> $page->GetPageStarNumber(),
            'n'			=> $number,
        ];
        $data = AssetsService::UserAssetsLogList($data_params,'FlowJfbAmount');
        // 用户状态
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));

        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data_list', $data['data']);
        return $this->fetch();
    }
    /**
     * 后台积分列表
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function jf()
    {

        // 参数
        $params = input();

        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowJfAmount');

        // 分页
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/useramount/jf'),
        );
        $page = new \base\Page($page_params);

        // 获取管理员列表
        $data_params = [
            'where'		=> $where,
            'm'			=> $page->GetPageStarNumber(),
            'n'			=> $number,
        ];
        $data = AssetsService::UserAssetsLogList($data_params,'FlowJfAmount');
        // 用户状态
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));

        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data_list', $data['data']);
        return $this->fetch();
    }
    /**
     * 后台股权列表
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function gq()
    {

        // 参数
        $params = input();

        // 条件
        $where = AssetsService::UserAssetsLogListWhere($params);

        // 总数
        $total = AssetsService::UserAssetsLogTotal($where,'FlowGqAmount');

        // 分页
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/useramount/gq'),
        );
        $page = new \base\Page($page_params);

        // 获取管理员列表
        $data_params = [
            'where'		=> $where,
            'm'			=> $page->GetPageStarNumber(),
            'n'			=> $number,
        ];
        $data = AssetsService::UserAssetsLogList($data_params,'FlowGqAmount');
        // 用户状态
        $this->assign('common_bd_log_type_list', lang('common_bd_log_type_list'));

        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data_list', $data['data']);
        return $this->fetch();
    }

    /**奖金币提现审核  通过
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function check_jj_success(){
        // 参数
        $params = input();
        if($params['succ_id']){
            $data = [
                'checkstatus'        => 1,
                'checktime'          =>date('Y-m-d H:i:s'),
            ];
            $res=Db::name('FlowJjAmount')->where(['id'=>$params['succ_id']])->update($data);
        }
        if($res){
            return DataReturn('提现审核通过', 0);
        }
        return DataReturn('系统异常,稍后重试', -1);
    }
    /**奖金币提现审核  打回
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function check_jj_fail(){
        // 参数
        $params = input();
        if($params['succ_id']){
            $data = [
                'checkstatus'        => 2,
                'checktime'          =>date('Y-m-d H:i:s'),
            ];
            $res=Db::name('FlowJjAmount')->where(['id'=>$params['succ_id']])->update($data);
        }
        if($res){
            return DataReturn('提现请求己打回', 0);
        }
        return DataReturn('系统异常,稍后重试', -1);
    }
}
?>