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
class UserController extends AdminBaseController
{

    /**
     * 管理员列表
     * @adminMenu(
     *     'name'   => '管理员',
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
     * 管理员添加
     * @adminMenu(
     *     'name'   => '管理员添加',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '管理员添加',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        $content = hook_one('admin_user_add_view');

        if (!empty($content)) {
            return $content;
        }
        $center = Db::name('center')->where(['status' => 1])->order("id DESC")->select();
        $this->assign("center", $center);


        $roles = Db::name('role')->where(['status' => 1])->order("id DESC")->select();
        $this->assign("roles", $roles);
        return $this->fetch();
    }

    /**
     * 管理员添加提交
     * @adminMenu(
     *     'name'   => '管理员添加提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '管理员添加提交',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            if (!empty($_POST['role_id']) && is_array($_POST['role_id'])) {
                $role_ids = $_POST['role_id'];
                unset($_POST['role_id']);
                $result = $this->validate($this->request->param(), 'User.edit');
                if ($result !== true) {
                    $this->error($result);
                } else {
                    $_POST['user_pass'] = cmf_password($_POST['user_pass']);
                    $_POST['admin_id'] = session('ADMIN_ID');
                    //
                    $center_id=$_POST['center_id'];
                    $center_info=Db::name('center')->where(['id'=>$center_id])->find();
                    $_POST['project_id']=$center_info['project_id'];
                    $result             = DB::name('user')->insertGetId($_POST);
                    if ($result !== false) {
                        //$role_user_model=M("RoleUser");
                        foreach ($role_ids as $role_id) {
                            if (cmf_get_current_admin_id() != 1 && $role_id == 1) {
                                $this->error("为了网站的安全，非网站创建者不可创建超级管理员！");
                            }
                            Db::name('RoleUser')->insert(["role_id" => $role_id, "user_id" => $result]);
                        }
                        //记录
                        $log='管理员添加提交';
                        $action=$this->action;
                        cmf_action_log($action,$log,json_encode($_POST));
                        $this->success("添加成功！", url("user/index"));
                    } else {
                        $this->error("添加失败！");
                    }
                }
            } else {
                $this->error("请为此用户指定角色！");
            }

        }
    }

    /**
     * 管理员编辑
     * @adminMenu(
     *     'name'   => '管理员编辑',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '管理员编辑',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $content = hook_one('admin_user_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $center = Db::name('center')->where(['status' => 1])->order("id DESC")->select();
        $this->assign("center", $center);

        $id    = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where(['status' => 1])->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where(["user_id" => $id])->column("role_id");
        $this->assign("role_ids", $role_ids);

        $user = DB::name('user')->where(["id" => $id])->find();
        $this->assign($user);
        return $this->fetch();
    }

    /**
     * 管理员编辑提交
     * @adminMenu(
     *     'name'   => '管理员编辑提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '管理员编辑提交',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        if ($this->request->isPost()) {
            if (!empty($_POST['role_id']) && is_array($_POST['role_id'])) {
                if (empty($_POST['user_pass'])) {
                    unset($_POST['user_pass']);
                } else {
                    $_POST['user_pass'] = cmf_password($_POST['user_pass']);
                }
                $role_ids = $this->request->param('role_id/a');
                unset($_POST['role_id']);
                $result = $this->validate($this->request->param(), 'User.edit');

                if ($result !== true) {
                    // 验证失败 输出错误信息
                    $this->error($result);
                } else {
                    $center_id=$_POST['center_id'];
                    $center_info=Db::name('center')->where(['id'=>$center_id])->find();
                    $_POST['project_id']=$center_info['project_id'];
                    $result = DB::name('user')->update($_POST);
                    if ($result !== false) {
                        $uid = $this->request->param('id', 0, 'intval');
                        DB::name("RoleUser")->where(["user_id" => $uid])->delete();
                        foreach ($role_ids as $role_id) {
                            if (cmf_get_current_admin_id() != 1 && $role_id == 1) {
                                $this->error("为了网站的安全，非网站创建者不可创建超级管理员！");
                            }
                            DB::name("RoleUser")->insert(["role_id" => $role_id, "user_id" => $uid]);
                        }
                        //记录
                        $log='管理员编辑提交';
                        $action=$this->action;
                        cmf_action_log($action,$log,json_encode($_POST));
                        $this->success("保存成功！");
                    } else {
                        $this->error("保存失败！");
                    }
                }
            } else {
                $this->error("请为此用户指定角色！");
            }

        }
    }

    /**
     * 管理员个人信息修改
     * @adminMenu(
     *     'name'   => '个人信息',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '管理员个人信息修改',
     *     'param'  => ''
     * )
     */
    public function userInfo()
    {
        $id   = cmf_get_current_admin_id();
        $user = Db::name('user')->where(["id" => $id])->find();
        $this->assign($user);
        return $this->fetch();
    }

    /**
     * 管理员个人信息修改提交
     * @adminMenu(
     *     'name'   => '管理员个人信息修改提交',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '管理员个人信息修改提交',
     *     'param'  => ''
     * )
     */
    public function userInfoPost()
    {
        if ($this->request->isPost()) {

            $data             = $this->request->post();
            $data['birthday'] = strtotime($data['birthday']);
            $data['id']       = cmf_get_current_admin_id();
            $create_result    = Db::name('user')->update($data);;
            if ($create_result !== false) {
                //记录
                        $log='管理员个人信息修改提交';
                        $action=$this->action;
                        cmf_action_log($action,$log,json_encode($data));
                $this->success("保存成功！");
            } else {
                $this->error("保存失败！");
            }
        }
    }

    /**
     * 管理员删除
     * @adminMenu(
     *     'name'   => '管理员删除',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '管理员删除',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id == 1) {
            $this->error("最高管理员不能删除！");
        }

        if (Db::name('user')->delete($id) !== false) {
            Db::name("RoleUser")->where(["user_id" => $id])->delete();
             //记录
                $log='管理员删除';
                $action=$this->action;
                $data['id']=$id;
                cmf_action_log($action,$log,json_encode($data));
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 停用管理员
     * @adminMenu(
     *     'name'   => '停用管理员',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '停用管理员',
     *     'param'  => ''
     * )
     */
    public function ban()
    {
        $id = $this->request->param('id', 0, 'intval');
        if (!empty($id)) {
            $result = Db::name('user')->where(["id" => $id, "user_type" => 1])->setField('user_status', '0');
            if ($result !== false) {
                    //记录
                    $log='停用管理员';
                    $action=$this->action;
                    $data['id']=$id;
                    cmf_action_log($action,$log,json_encode($data));
                $this->success("管理员停用成功！", url("user/index"));
            } else {
                $this->error('管理员停用失败！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    /**
     * 启用管理员
     * @adminMenu(
     *     'name'   => '启用管理员',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '启用管理员',
     *     'param'  => ''
     * )
     */
    public function cancelBan()
    {
        $id = $this->request->param('id', 0, 'intval');
        if (!empty($id)) {
            $result = Db::name('user')->where(["id" => $id, "user_type" => 1])->setField('user_status', '1');
            if ($result !== false) {
                      //记录
                    $log='启用管理员';
                    $action=$this->action;
                    $data['id']=$id;
                    cmf_action_log($action,$log,json_encode($data));
                $this->success("管理员启用成功！", url("user/index"));
            } else {
                $this->error('管理员启用失败！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }


    /**
     * 增加受试者
     *
     */
    public function user_add()
    {
        //所属分组
        $group_list=Db::name('group')->select();
        $this->assign('group_list',$group_list);
        return $this->fetch();
    }

    /**
     * 编辑受试者
     *
     */
    public function user_edit()
    {
        if (!empty($content)) {
            return $content;
        }
        $id    = $this->request->param('id', 0, 'intval');
        $user = DB::name('user')->where(["id" => $id])->find();
         //所属分组
        $group_list=Db::name('group')->select();
        $this->assign('group_list',$group_list);

        $this->assign('info',$user);
        return $this->fetch();

    }

    /**
     * 受试者列表
     *
     */

    public function user_list()
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
                        ->field('u.*,c.center_name,g.group_name')
                        ->whereOr($keywordComplex)
                        ->alias('u')
                        ->join('center c','c.id = u.center_id')
                        ->join('group g','g.id = u.group')
                        ->where($where)
                        ->order("u.id DESC")
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
     * 增加受试者
     *
     */

    public function adduserpost()
    {
        if($this->request->isPost())
        {
            $request=$this->request->param();
            $data=$request['post'];
            $result = $this->validate($data, 'User.adduser');
            if ($result !== true) {
                $this->error($result);
            }else{
                //受试者user_type=2
                $data['user_type']=2;
                $data['admin_id']=$_SESSION['think']['ADMIN_ID'];
                $data['center_id']=$_SESSION['think']['CENTER_ID'];
                $data['create_time']=time();
                //根据center_id 查project_id
                $center_info=Db::name('center')->field('project_id')->where(['id'=>$data['center_id']])->find();
                $res =Db::name('user')->insertGetId($data);
                if ($res !== false) {
                            //记录
                            $log='增加受试者';
                            $action=$this->action;
                            cmf_action_log($action,$log,json_encode($data),$res);
                    $this->success("受试者添加成功！", url("admin/user/user_list"));
                } else {
                    $this->error('受试者添加失败！');
                }

            }
             $this->error('受试者添加失败！');

        }

    }

    /**
     * 编辑受试者
     *
     */

    public function edituserpost()
    {
        if($this->request->isPost())
        {
            $request=$this->request->param();
            $data=$request['post'];
            $user_id=$request['id'];
                //受试者user_type=2
                $res =Db::name('user')->where(['id'=>$user_id])->update($data);
                if ($res !== false) {
                            //记录
                            $log='编辑受试者';
                            $action=$this->action;
                            cmf_action_log($action,$log,json_encode($data),$user_id);
                    $this->success("受试者编辑成功！", url("admin/user/user_list"));
                } else {
                    $this->error('受试者编辑失败！');
                }

            
             $this->error('受试者编辑失败！');

        }

    }


    /**
    *查看用户crf
     * user_crf
     */

    public function user_crf()
    {
        //只能查看自己的crf
        // 0 未录入 1首次录入 2 二次录入 3 完成 4签名
        $crf_status=array('0'=>'未录入','1'=>'首次录入','2'=>'二次录入','3'=>'录入完成','4'=>'签名',);
        $admin_id=$_SESSION['think']['ADMIN_ID'];
        $user_id=$this->request->param('id');
        $project_info=Db::name('admin_project')
                ->where('project_student|project_charge','eq',$admin_id)
                ->find();
        $where['project_id']=$project_info['id'];
        $result=Db::name('admin_project_crf')->where($where)->order('event_num asc , sort asc')->select();
        //字母
        $letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        //录入的数据
        $where_crf['user_id']=$user_id;
        $where_crf['project_id']=$project_info['id'];
        $user_crf=Db::name('admin_user_crf')->where($where_crf)->select();
        //foreach
        $new_crf=array();
        foreach ($user_crf as $k=>$v)
        {
            $key=$v['crf_id'];
            $new_crf[$key]=$v;
        }
        
        $this->assign('user_crf',$new_crf);
        $this->assign('result',$result);
        //将crf结果格式化
        $crf_result=array();
        foreach($result as $k=>$v)
        {

           $crf_result[$v['event_num']][]=$v;
            
        }
        //信息
        $user_info=Db::name('user')->field('user_login,user_sn,crf_status')->where(array('id'=>$user_id))->find();
        $this->assign('crf_result',$crf_result);
        $this->assign('user_id',$user_id);
        $this->assign('crf_status',$crf_status);
        $this->assign('user_info',$user_info);
        $this->assign('project_id',$project_info['id']);
        $this->assign('letter',$letter);
        return $this->fetch();
    }


    /**
    *审查受试者数据
     * check_user_crf
     */

    public function check_user_crf()
    {
        //只能查看自己的crf
        $admin_id=$_SESSION['think']['ADMIN_ID'];
        $user_id=$this->request->param('id');
        //

        $project_info=Db::name('admin_project')
                ->where('project_student|project_charge','eq',$admin_id)
                ->find();
        $where['project_id']=$project_info['id'];
        $result=Db::name('admin_project_crf')->where($where)->order('event_num asc , sort asc')->select();
        //字母
        $letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        //录入的数据
        $where_crf['user_id']=$user_id;
        $where_crf['project_id']=$project_info['id'];
        $res=Db::name('admin_user_crf')->where($where_crf)->find();
        if(empty($res))
        {
             $this->redirect('admin/user/user_crf', ['id' => $user_id]);

        }
        $user_crf=Db::name('admin_user_crf')->where($where_crf)->select();
        //foreach
        $new_crf=array();
        foreach ($user_crf as $k=>$v)
        {
            $key=$v['crf_id'];
            $new_crf[$key]=$v;
        }
        
        $this->assign('user_crf',$new_crf);
        $this->assign('result',$result);
        //将crf结果格式化
        $crf_result=array();
        foreach($result as $k=>$v)
        {

           $crf_result[$v['event_num']][]=$v;
            
        }
        $this->assign('crf_result',$crf_result);
        $this->assign('user_id',$user_id);
        $this->assign('project_id',$project_info['id']);
        $this->assign('letter',$letter);

        return $this->fetch();
    }

    /**
     *录入受试者数据
     *
     */

    public function crfpost()
    {
        // print_r($_REQUEST);die;
        if($this->request->isPost())
        {

            $request = $this->request->param();
            $user_id=$request['user_id'];
            $project_id=$request['project_id'];
            $crf=$request['crf'];
            
            Db::startTrans();
            try{
                foreach($crf as $key=>$value)
                {
                    $where['user_id']=$user_id;
                    $where['crf_id']=$key;
                    $data['user_id']=$user_id;
                    $data['crf_id']=$key;
                    $data['project_id']=$project_id;
                    if(is_array($value))
                    {
                        $data['crf_desc']=json_encode($value);
                    }else{
                        $data['crf_desc']=$value;
                    }
                    $res=Db::name('admin_user_crf')->where($where)->find();
                    if($res)
                    {
                        Db::name('admin_user_crf')->where($where)->update($data);
                        //二次录入
                        DB::name('user')->where(array('id'=>$user_id))->update(['crf_status'=>2]);
                    }else{
                        Db::name('admin_user_crf')->where($where)->insert($data);
                        //首次录入
                        DB::name('user')->where(array('id'=>$user_id))->update(['crf_status'=>1]);
                    }
                }
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $da['code']=1;
                $da['msg']='fail';
                $da['sql']=$e->getMessage();
                echo json_encode($da);die;
                
            }
                    //记录
                    $log='录入受试者数据';
                    $action=$this->action;
                    cmf_action_log($action,$log,json_encode($crf),$user_id);
                $da['code']=0;
                $da['msg']='success';
                echo json_encode($da);die;

        }


    }
    /*疑问页面*/
    public function user_ask()
    {
        $id=$this->request->param('id');
        $user_id=$this->request->param('user_id');
        //中心管理员
        $admin_id=$_SESSION['think']['ADMIN_ID'];

        if($admin_id==1)
        {
            $where_a=array();
            $where=array();
            $where['user_type']=1;
            $where['id']=array('neq',$admin_id);
        }else{
            $where_a['id']=$admin_id;
            $user_info=Db::name('user')->field('center_id')->where($where_a)->find();
            $where['center_id']=$user_info['center_id'];
            $where['id']=array('neq',$admin_id);
            $user_info=Db::name('user')->field('center_id')->where($where_a)->find();
            $where['center_id']=$user_info['center_id'];
            $where['id']=array('neq',$admin_id);
            $where['user_type']=1;
        }
       
        $center_list=Db::name('user')->field('id,user_login')->where($where)->select();
        $this->assign('center_list',$center_list);
        $this->assign('id',$id);
        $this->assign('user_id',$user_id);
        return $this->fetch();
    }
    /**
    *
    *疑问插入
    */
    public function askpost()
    {
        if($this->request->isPost())
        {
            $request = $this->request->param();
            $crf_id=$request['id'];
            $user_id=$request['user_id'];
            $where['id']=$crf_id;
            $crf_info=Db::name('admin_project_crf')->where($where)->find();
            if(empty($crf_info))
            {
                $da['code']=1;
                $da['msg']='数据错误';
                echo json_encode($da);die;
            }
            $ask=$request['ask'];
            $respone_id=$request['respone_id'];
            if(!$ask)
            {
                $da['code']=1;
                $da['msg']='提交疑问不能为空';
                echo json_encode($da);die;
            }
            $project_id=$crf_info['project_id'];
            $admin_id=$_SESSION['think']['ADMIN_ID'];
            if(!$ask)
            {
                $da['code']=1;
                $da['msg']='提交疑问不能为空';
                echo json_encode($da);die;
            }
            $save['respone_id']=$respone_id;
            $save['user_id']=$user_id;
            $askarray['ask']=$ask;
            $askarray['answer']='';
            $askarray['time']=time();
            $save['project_id']=$project_id;
            $save['admin_id']=$admin_id;
            $save['crf_id']=$crf_id;
            $save['add_time']=time();
            //查询疑问表中是否有同样的数据
            $where_c['crf_id']=$crf_id;
           
            $sa=array();
            array_push($sa, $askarray);
            $save['ask']=json_encode($sa);
            //插入
            $res=Db::name('user_ask')->data($save)->insert();
            if($res)
            {
                 //记录
                    $log='新增新疑问-插入';
                    $action=$this->action;
                    cmf_action_log($action,$log,json_encode($save),$user_id);
                $da['code']=0;
                $da['msg']='提交疑问成功';
                echo json_encode($da);die;
            }else{
                 $da['code']=1;
                 $da['msg']='提交疑问失败';
                echo json_encode($da);die;
            }
           
        }

    }

    //更新受试者状态
    public function updateUserStatus()
    {
         $crf_status = $this->request->param('crf_status');
         $user_id= $this->request->param('user_id');
         if(empty($crf_status))
         {
            $crf_status=0;
         }
         if(empty($user_id))
         {
            $data['code']=1;
            $data['msg']='缺少必要参数';
            echo json_encode($data);die;
         }
         $result=Db::name('user')->where(['id'=>$user_id])->update(['crf_status'=>$crf_status]);

        if($result)
            {
                //记录
                    $log='更新受试者状态';
                    $action=$this->action;
                    cmf_action_log($action,$log,json_encode($data),$user_id);
                $da['code']=0;
                $da['msg']='更新状态成功';
                echo json_encode($da);die;
            }else{
                 $da['code']=1;
                 $da['msg']='更新状态失败';
                echo json_encode($da);die;
            }


    }

    //签名页面
    public function sign()
    {
        $user_id=$this->request->param('user_id');
        if(!$user_id)
        {
            $this->error("错误hack");
        }
        //如果状态不是3 不能签名
        $info=Db::name('user')->where(['id'=>$user_id])->find();
        if($info['crf_status'] != 3)
        {
            $this->redirect('admin/user/user_crf', ['id' => $user_id]);
        }
        $this->assign('user_id',$user_id);
        return $this->fetch();
    }
    /**
    *对受试者数据进行签名
    */
    //
    public function doSign()
    {
        $user_id=$this->request->param('user_id');
        $password=$this->request->param('password');
        $captcha = $this->request->param('captcha');
        if (empty($captcha)) {
            $data['code']=2;
            $data['msg']='验证码不能为空';
            echo json_encode($data);die;
        }
        //验证码
        if (!cmf_captcha_check($captcha)) {
            $data['code']=2;
            $data['msg']='验证码错误';
            echo json_encode($data);die;
        }
        //密码验证
         if (empty($password)) {
            $data['code']=2;
            $data['msg']='密码不能为空';
            echo json_encode($data);die;
        }
        $admin_id=$_SESSION['think']['ADMIN_ID'];

        $info = Db::name('user')->where(['id'=>$admin_id])->find();
        if (cmf_password($password)==$info['user_pass']) {
                $result=Db::name('user')->where(['id'=>$user_id])->update(['crf_status'=>4]);
                if($result)
                {
                    //记录
                    $log='对受试者数据进行签名';
                    $action=$this->action;
                    cmf_action_log($action,$log,json_encode($data),$user_id);
                    $data['code']=0;
                    $data['msg']='success';
                    echo json_encode($data);die;
                }else{
                     $data['code']=2;
                    $data['msg']='更新失败';
                    echo json_encode($data);die;
                }
        }else{
            $data['code']=2;
            $data['msg']='输入密码错误';
            echo json_encode($data);die;
        }
        
    }

    /**
    *受试者分组
    */
    public function user_group()
    {

        $list = Db::name('group')
                        ->order("add_time DESC")
                        ->paginate(10);
        // 获取分页显示
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    /**
    *添加分组
    */
    public function group_add()
    {

        return $this->fetch();
    }

    /**
    *编辑分组
    */
    public function group_edit()
    {
        $id=$this->request->param('id');
        $info=Db::name('group')->where(['id'=>$id])->find();
        $this->assign('info',$info);
        return $this->fetch();
    }

    /**
    *提交数据
    */

    public function groupaddpost()
    {
        if($this->request->isPost())
        {
            $group_name=$this->request->param('group_name');
                $res =Db::name('group')->insert([
                    'add_time'=>time(),
                    'group_name'=>$group_name
                    ]);
                if ($res !== false) {
                            
                            $log='新增分组';
                            $action=$this->action;
                            $data['group_name']=$group_name;
                            cmf_action_log($action,$log,json_encode($data));
                    $this->success("新增分组成功！", url("admin/user/user_group"));
                } else {
                    $this->error('新增分组失败！');
                }

            
             $this->error('新增分组失败！');

        }
       
    }

     /**
    *提交编辑数据
    */

    public function groupeditpost()
    {
        if($this->request->isPost())
        {
            $group_name=$this->request->param('group_name');
            $id=$this->request->param('id');
                $res =Db::name('group')->where(['id'=>$id])->update([
                    'add_time'=>time(),
                    'group_name'=>$group_name
                    ]);
                if ($res !== false) {
                            
                            $log='编辑分组';
                            $action=$this->action;
                            $data['group_name']=$group_name;
                            cmf_action_log($action,$log,json_encode($data));
                    $this->success("编辑分组成功！", url("admin/user/user_group"));
                } else {
                    $this->error('编辑分组失败！');
                }

             $this->error('编辑分组失败！');

        }
       
    }






}