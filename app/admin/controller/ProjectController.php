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

use app\admin\model\ProjectModel;
use cmf\controller\AdminBaseController;
use think\Db;

class ProjectController extends AdminBaseController
{


    /**
     * 项目
    */
    public function index()
    {
        $content = hook_one('admin_rbac_index_view');

        if (!empty($content)) {
            return $content;
        }

        $project = new ProjectModel();
        $data = $project::with(['principal','user'])->select()
                        /*->visible([
                            'id',
                            'project_name',
                            'status',
                            'principal.user_nickname'
                        ])*/->toArray();
        $this->assign("project", $data);
        return $this->fetch();
    }
    /*
    *添加项目
    */
    public function add()
    {
        $user = Db::name('user')->select()->toArray();
        $this->assign('user',$user);
        return $this->fetch();
    }
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $data['create_people'] = session('ADMIN_ID');
            $result = Db::name('m_project')->insert($data);
            if ($result) {
                $this->success("操作成功", url("project/index"));
            } else {
                $this->error("操作失败");
            }
            /*$result = $this->validate($data, 'role');
            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $result = Db::name('role')->insert($data);
                if ($result) {
                    $this->success("添加角色成功", url("rbac/index"));
                } else {
                    $this->error("添加角色失败");
                }

            }*/
        }
    }

     /*
    *生成项目crf
    */
    public function edcadd()
    {

        return $this->fetch();
    }
}
