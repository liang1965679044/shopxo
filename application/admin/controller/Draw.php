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

/**
 * 问答管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Draw extends Common
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
    function chenwu(){
        return 1;
    }
    /**
     * 问答列表
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
    public function Index()
    {

        $data = Db::name('Draw')->select();
        // 参数
        $this->assign('data_list', $data);
        return $this->fetch();
    }

    /**
     * [SaveInfo 添加/编辑页面]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-14T21:37:02+0800
     */
    public function SaveInfo()
    {

        $id=input();
        if(!empty($id['id'])){
            $data=Db::name('Draw')->where(['id' => $id['id']])->find();
            $this->assign('data',$data);
        }

        return $this->fetch();
    }

    /**
     * [Save 保存]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-25T22:36:12+0800
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
        if(empty($params['name'])){
            return DataReturn('奖品名称不能为空', -1);
        }
        if(empty($params['rank'])){
            return DataReturn('奖品顺序不能为空', -1);
        }
        if(empty($params['percent'])){
            return DataReturn('奖品概率不能为空', -1);
        }
        if(empty($params['score'])){
            return DataReturn('奖品积分不能为空', -1);
        }
        $data = array(
            'name'              =>  $params['name'],
            'rank'              =>  $params['rank'],
            'percent'           =>  $params['percent'],
            'score'             =>  $params['score'],
        );
        //修改
        if(!empty($params['id'])){
            $update_res=Db::name('Draw')->where(['id' => $params['id']])->update($data);
            if($update_res){
                return  DataReturn('修改成功', 0);
            }else{
                return  DataReturn('修改失败', -1);
            }
        }
        if(Db::name('Draw')->insertGetId($data) > 0){
            return  DataReturn('增加成功', 0);
        }
        return  DataReturn('增加失败', -1);

    }

    /**
     * 删除
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-15T11:03:30+0800
     */
    public function Delete()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        // 删除操作
        if(Db::name('Draw')->delete(intval($params['id'])))
        {
            return DataReturn('删除成功');
        }
        return DataReturn('删除失败或资源不存在', -100);
    }
}
?>