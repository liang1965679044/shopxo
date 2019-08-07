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
}