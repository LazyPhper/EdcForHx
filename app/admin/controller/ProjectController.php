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
 * Class ProjectController
 * @package app\admin\controller
 * @adminMenuRoot(
 *     'name'   => '项目管理',
 *     'action' => 'default',
 *     'parent' => '',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   => '',
 *     'remark' => ''
 * )
 */
class ProjectController extends AdminBaseController
{

    /**
     * 项目列表
     * @adminMenu(
     *     'name'   => '项目列表',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '管理员管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $content = hook_one('admin_user_index_view');

        if (!empty($content)) {
            return $content;
        }

        $where = ["user_type" => 1];
        /**搜索条件**/
        $userLogin = $this->request->param('user_login');
        $userEmail = trim($this->request->param('user_email'));

        if ($userLogin) {
            $where['user_login'] = ['like', "%$userLogin%"];
        }

        if ($userEmail) {
            $where['user_email'] = ['like', "%$userEmail%"];;
        }
        $users = Db::name('user')
            ->where($where)
            ->order("id DESC")
            ->paginate(10);
        $users->appends(['user_login' => $userLogin, 'user_email' => $userEmail]);
        // 获取分页显示
        $page = $users->render();

        $rolesSrc = Db::name('role')->select();
        $roles    = [];
        foreach ($rolesSrc as $r) {
            $roleId           = $r['id'];
            $roles["$roleId"] = $r;
        }
        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("users", $users);
        return $this->fetch();
    }

    /**
     * 项目添加
     * @adminMenu(
     *     'name'   => '项目添加',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '项目添加',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        return $this->fetch();
    }
}