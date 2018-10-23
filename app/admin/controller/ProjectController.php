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

class ProjectController extends AdminBaseController
{


    /**
     * 项目
    */
    public function index()
    {
        $content = hook_one('admin_user_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $project_name = $this->request->param('project_name');
        $project_sn = trim($this->request->param('project_sn'));
        $where['id']=array('gt',0);
        if ($project_name) {
            $where['project_name'] = ['like', "%$project_name%"];
        }

        if ($project_sn) {
            $where['project_sn'] = ['like', "%$project_sn%"];;
        }
        $list = Db::name('admin_project')
            ->where($where)
            ->order("id DESC")
            ->paginate(10);
        $list->appends(['project_sn' => $project_sn, 'project_name' => $project_name]);
        // 获取分页显示
        $page = $list->render();

        $this->assign("page", $page);
        $this->assign("list", $list);
        return $this->fetch();
    }
    /*
    *添加项目
    */
    public function add()
    {

        return $this->fetch();
    }

    /*插入数据库项目内容*/
    public function addPost()
    {

        if ($this->request->isPost()) {
            $data=$this->request->param();
            $result = $this->validate($data['post'], 'Project.add');
            if ($result !== true) {
                $this->error($result);
            }

            $result_condition = $this->validate($data['condition'], 'Project.condition');
            if ($result_condition !== true) {
                $this->error($result_condition);
            }
            $project=$data['post'];
            $project_device=$data['device'];
            $project_condition=$data['condition'];
            $project_config=$data['config'];
            //开始事务
            Db::startTrans();
            try{
                $project_id=Db::name('admin_project')->insertGetId($project);
                $project_condition['project_id']=$project_id;
                $project_device['project_id']=$project_id;
                $project_config['project_id']=$project_id;
                Db::name('admin_project_condition')->insert($project_condition);
                Db::name('admin_project_device')->insert($project_device);
                Db::name('admin_project_config')->insert($project_config);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error("添加失败！");
            }
            $this->success("添加成功！", url("project/index"));

        }
//        print_r($project['post']);
    }


    /*编辑项目信息*/
    public function edit()
    {
        $id   = $this->request->param('id', 0, 'intval');
        $project_info = DB::name('admin_project')->where(['id' => $id])->find();
        $project_device = DB::name('admin_project_device')->where(['project_id' => $id])->find();
        $project_condition = DB::name('admin_project_condition')->where(['project_id' => $id])->find();
        $project_config = DB::name('admin_project_config')->where(['project_id' => $id])->find();
        $this->assign("project_info", $project_info);
        $this->assign("project_device", $project_device);
        $this->assign("project_condition", $project_condition);
        $this->assign("project_config", $project_config);
        return $this->fetch();
    }

    /*编辑项目信息  提交*/
    public function editPost()
    {
        if ($this->request->isPost()) {
            $id=$this->request->param('project_id');
            $data=$this->request->param();
            $result = $this->validate($data['post'], 'Project.edit');
            if ($result !== true) {
                $this->error($result);
            }

            $result_condition = $this->validate($data['condition'], 'Project.condition');
            if ($result_condition !== true) {
                $this->error($result_condition);
            }
            $project=$data['post'];
            $project_device=$data['device'];
            $project_condition=$data['condition'];
            $project_config=$data['config'];
            //开始事务
            $where['id']=$id;
            $where_p['project_id']=$id;
            Db::startTrans();
            try{
                $project_id=Db::name('admin_project')->where($where)->update($project);

                Db::name('admin_project_condition')->where($where_p)->update($project_condition);
                Db::name('admin_project_device')->where($where_p)->update($project_device);
                Db::name('admin_project_config')->where($where_p)->update($project_config);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error("修改失败！");
            }
            $this->success("修改成功！", url("project/index"));

        }

    }
     /*
    *生成项目crf
    */
    public function edcadd()
    {
        $project_id=$this->request->param('id');

        $this->assign('project_id',$project_id);
        return $this->fetch();
    }

    /*
     * 项目规则
     * */

    public function project_rule()
    {
        return $this->fetch();
    }


    /*
     * 生成数据输入页面
     * */
    public function project_edc()
    {
        return $this->fetch();
    }


}
