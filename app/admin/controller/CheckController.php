<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;

/**
 * Class UserController
 * @package app\admin\controller
 * @adminMenuRoot(
 *     'name'   => '管理组',
 *     'action' => 'default',
 *     'parent' => 'user/AdminIndex/default',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => '',
 *     'remark' => '管理组'
 * )
 */
class CheckController extends AdminBaseController
{

    /**
     * 受试者列表
     *
     */

    public function index()
    {
        if (!empty($content)) {
            return $content;
        }
        // 0 未录入 1首次录入 2 二次录入 3 完成 4签名
        $crf_status=array('0'=>'未录入','1'=>'首次录入','2'=>'二次录入','3'=>'录入完成','4'=>'签名',);

        $where   = [];
        $request = input('request.');
         $usersQuery = Db::name('user');
        //
        if (!empty($request['uid'])) {
            $where['id'] = intval($request['uid']);
        }
        $where['user_type']=2;
        $where['u.admin_id']=$_SESSION['think']['ADMIN_ID'];
        //查出center_id
        $where_a['id']=$_SESSION['think']['ADMIN_ID'];
        $info = $usersQuery->where($where_a)->find();
        $center_id=$info['center_id'];
        $center_name='未选择中心';
        if($center_id)
        {
            $where['center_id']=$center_id;
            $center_info=Db::name('center')->where(array('id'=>$center_id))->find();
            $center_name=$center_info['center_name'];
        }
       
        
        $keywordComplex = [];
        if (!empty($request['keyword'])) {
            $keyword = $request['keyword'];

            $keywordComplex['user_login|user_nickname|user_email|mobile']    = ['like', "%$keyword%"];
        }
       
        $list = $usersQuery
                        ->field('u.*,c.center_name')
                        ->whereOr($keywordComplex)
                        ->alias('u')
                        ->join('center c','c.id = u.center_id')
                        ->where($where)
                        ->order("create_time DESC")
                        ->paginate(10);
        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('crf_status', $crf_status);
        $this->assign('center_name', $center_name);
        // 渲染模板输出
        return $this->fetch();
    }


    /**
     * 稽查列表
     *
     */

    public function check_list()
    {
        if (!empty($content)) {
            return $content;
        }

        $where   = [];
        $id = $this->request->param('id');
        $action_log = Db::name('action_log');
        $where['user_id'] = intval($id);

        $list = $action_log
                        ->field('a.*,u.user_login')
                        ->alias('a')
                        ->join('user u','u.id=a.admin_id')
                        ->where($where)
                        ->order("time DESC")
                        ->paginate(10);
        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }




}