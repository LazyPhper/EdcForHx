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
use app\admin\model\Menu;

class MainController extends AdminBaseController
{

    public function _initialize()
    {
        parent::_initialize();
        //$this->action 访问url
    }

    /**
     *  后台欢迎页
     */
    public function index()
    {
     
        //查询疑问
        $admin_id=$_SESSION['think']['ADMIN_ID'];
        if($admin_id==1)
        {
            //
        }else{
            $where['respone_id']=$admin_id;
            $where_1['respone_id']=$admin_id;
            $where_2['respone_id']=$admin_id;
        }

        //新提问
        $where['status']=1;
        $where['respone_status']=0;
        $count = Db::name('user_ask')
            ->where($where)
            ->count();
        $this->assign("count", $count);
        //更新的提问
        $where_1['status']=1;
        $where_1['respone_status']=1;
        $count_ask = Db::name('user_ask')
            ->where($where_1)
            ->count();
        $this->assign("count_ask", $count_ask);

        //统计结束疑问数量生成列表
        $where_2['status']=2;

        // $where_1['respone_status']=1;
        $count_gone = Db::name('user_ask')
            ->where($where_2)
            ->count();
        $this->assign("count_gone", $count_gone);
        //查出所有列表
        /**搜索条件**/
        $admin_id=$_SESSION['think']['ADMIN_ID'];
        if($admin_id==1)
        {
            //
             $where_l['cp.sort']=0;
             $whereComplex= [];

        }else{

            $whereComplex['ua.admin_id|ua.respone_id'] = $admin_id;
            $where_l['cp.sort']=0;
        }
        $list = Db::name('user_ask')
                ->alias('ua')
                ->field('c.*,p.project_name,ua.admin_id,ua.ask,ua.user_id,ua.status,ua.respone_status,ua.crf_id,ua.id ask_id,cp.event_desc,u.user_login,u.user_sn,ce.center_name')
                ->join('admin_project_crf c','c.id = ua.crf_id')
                ->join('admin_project p','p.id = ua.project_id')
                ->join('admin_project_crf cp','cp.event_num = c.event_num')
                ->join('user u','ua.user_id = u.id')
                ->join('center ce','ce.id = u.center_id')
                ->whereOr($whereComplex)
                ->where($where_l)
                ->order("ua.id DESC")
                ->paginate(10);
        // 获取分页显示
        
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function dashboardWidget()
    {
        $dashboardWidgets = [];
        $widgets          = $this->request->param('widgets/a');
        if (!empty($widgets)) {
            foreach ($widgets as $widget) {
                if ($widget['is_system']) {
                    array_push($dashboardWidgets, ['name' => $widget['name'], 'is_system' => 1]);
                } else {
                    array_push($dashboardWidgets, ['name' => $widget['name'], 'is_system' => 0]);
                }
            }
        }

        cmf_set_option('admin_dashboard_widgets', $dashboardWidgets, true);

        $this->success('更新成功!');

    }

    /**
     *疑问列表 
     */
    public function asklist()
    {
        $content = hook_one('admin_user_index_view');

        if (!empty($content)) {
            return $content;
        }
        /**搜索条件**/
        $admin_id=$_SESSION['think']['ADMIN_ID'];
        if($admin_id==1)
        {
            //
        }else{
            $where['admin_id|respone_id']=$admin_id;
        }
        $where['status']=1;
        $where['respone_status']=0;
        $list = Db::name('user_ask')
            ->alias('ua')
            ->field('c.*,p.project_name,ua.admin_id,ua.ask,ua.user_id,ua.status,ua.respone_status,ua.crf_id,ua.id ask_id')
            ->join('admin_project_crf c','c.id = ua.crf_id')
            ->join('admin_project p','p.id = ua.project_id')
            ->where($where)
            ->order("id DESC")
            ->paginate(10);
        // 获取分页显示
        $items = $list->items();
        foreach ($items as $key => $value) {
            $whee['user_id']=$value['user_id'];
            $whee['crf_id']=$value['crf_id'];
            $crf=Db::name('admin_user_crf')->field('crf_desc')->where($whee)->find();
            $items[$key]['crf_desc']=$crf['crf_desc'];
        }
        $page = $list->render();;
        $this->assign("page", $page);
        $this->assign("list", $items);
        $letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $this->assign("letter", $letter);
        return $this->fetch();

    }

    /**
     *疑问列表 
     */
    public function answerlist()
    {
        $content = hook_one('admin_user_index_view');

        if (!empty($content)) {
            return $content;
        }
        /**搜索条件**/
        $admin_id=$_SESSION['think']['ADMIN_ID'];
        if($admin_id==1)
        {
            //
        }else{
            $where['admin_id|respone_id']=$admin_id;
        }
        $where['status']=1;
        $where['respone_status']=1;
        $list = Db::name('user_ask')
            ->alias('ua')
            ->field('c.*,p.project_name,ua.admin_id,ua.ask,ua.user_id,ua.status,ua.respone_status,ua.crf_id,ua.id ask_id')
            ->join('admin_project_crf c','c.id = ua.crf_id')
            ->join('admin_project p','p.id = ua.project_id')
            ->where($where)
            ->order("id DESC")
            ->paginate(10);
        // 获取分页显示
        $items = $list->items();
        foreach ($items as $key => $value) {
            $whee['user_id']=$value['user_id'];
            $whee['crf_id']=$value['crf_id'];
            $crf=Db::name('admin_user_crf')->field('crf_desc')->where($whee)->find();
            $items[$key]['crf_desc']=$crf['crf_desc'];
        }
       
        $page = $list->render();
        $this->assign("page", $page);
        $this->assign("list", $items);
     
        $letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $this->assign("letter", $letter);
        return $this->fetch();

    }

    //查看某个疑问
    public function info()
    {
        $content = hook_one('admin_user_index_view');

        if (!empty($content)) {
            return $content;
        }
        /**搜索条件**/
        $id=$this->request->param('id');
        $where['ua.id']=$id;
        $info = Db::name('user_ask')
            ->alias('ua')
            ->field('c.*,p.project_name,ua.admin_id,ua.ask,ua.user_id,ua.status,ua.respone_status,ua.crf_id,ua.id ask_id')
            ->join('admin_project_crf c','c.id = ua.crf_id')
            ->join('admin_project p','p.id = ua.project_id')
            ->where($where)
            ->find();
        // 获取分页显示
        // $items = $list->items();
            $whee['user_id']=$info['user_id'];
            $whee['crf_id']=$info['crf_id'];
            $crf=Db::name('admin_user_crf')->field('crf_desc')->where($whee)->find();
            $info['crf_desc']=$crf['crf_desc'];
        
        $this->assign("v", $info);
        $letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $this->assign("letter", $letter);
        return $this->fetch();
    }


    //回复
    public function answer()
    {
        
        $request = $this->request->param();
        $id=$request['id'];
        $answer=$request['answer'];
        $where['id']=$id;
        $ask_info=Db::name('user_ask')->where($where)->find();
        if($ask_info['respone_status']==1)
        {
            $data['code']=1;
            $data['msg']='您暂时不能进行回复';
            echo json_encode($data);die;
        }
        if(session('ADMIN_ID')==1)
        {
            //判断权限
        }else{
            //
            if($ask_info['respone_id'] != session('ADMIN_ID'))
            {
                $data['code']=1;
                $data['msg']='您不能进行回复';
                echo json_encode($data);die;
            }

        }
        
        $ask_json=$ask_info['ask'];
        $ask_json=json_decode($ask_json,true);
        //最后一个数组
        $ask_last=array_pop($ask_json);
        $ask_last['answer']=$answer;
        $ask_last['respone_time']=time();
        //
        array_push($ask_json,$ask_last);
        $save['respone_status']=1;
        $save['ask']=json_encode($ask_json);
        $result=Db::name('user_ask')->where($where)->update($save);
        if($result)
        {
            $log='回复疑问';
            $action=$this->action;
            $user_id=$ask_info['user_id'];
            cmf_action_log($action,$log,json_encode($save),$user_id);
            $data['code']=0;
            $data['msg']='回复成功';
            echo json_encode($data);die;
        }else{
            $data['code']=1;
            $data['msg']='提交失败';
            echo json_encode($data);die;
        }
        //根据id 插入回复
    }

    //疑问
    public function ask()
    {
        
        $request = $this->request->param();
        $id=$request['id'];
        $ask=$request['ask'];
        $where['id']=$id;
        $ask_info=Db::name('user_ask')->where($where)->find();
        if(session('ADMIN_ID')==1)
        {
            //判断权限
        }else{
            //
            if($ask_info['admin_id'] != session('ADMIN_ID'))
            {
                $data['code']=1;
                $data['msg']='您不能提交疑问';
                echo json_encode($data);die;
            }

        }
        $ask_json=$ask_info['ask'];
        $ask_json=json_decode($ask_json,true);
         //最后一个数组
        $ask_last['ask']=$ask;
        $ask_last['answer']='';
        $ask_last['time']=time();
        $ask_last['respone_time']='';
        //
        array_push($ask_json, $ask_last);
        $save['respone_status']=0;
        $save['ask']=json_encode($ask_json);
        $result=Db::name('user_ask')->where($where)->update($save);
        if($result)
        {
            $log='提交疑问';
            $action=$this->action;
            $user_id=$ask_info['user_id'];
            cmf_action_log($action,$log,json_encode($save),$user_id);
            $data['code']=0;
            $data['msg']='提交疑问成功';
            echo json_encode($data);die;
        }else{
            $data['code']=1;
            $data['msg']='提交失败';
            echo json_encode($data);die;
        }
        //根据id 插入回复
    }

    //结束疑问
    public function end()
    {
       
        $request = $this->request->param();
        $id=$request['id'];
        $ask=$request['ask'];
        $where['id']=$id;
        $ask_info=Db::name('user_ask')->where($where)->find();
        if(session('ADMIN_ID')==1)
        {
            //判断权限
        }else{
            //
            if($ask_info['admin_id'] != session('ADMIN_ID'))
            {
                $data['code']=1;
                $data['msg']='您不能结束疑问';
                echo json_encode($data);die;
            }

        }
        $save['respone_status']=1;
        $save['status']=2;
        $result=Db::name('user_ask')->where($where)->update($save);
        if($result)
        {
            $log='结束疑问';
            $action=$this->action;
            $user_id=$ask_info['user_id'];
            cmf_action_log($action,$log,json_encode($save),$user_id);
            $data['code']=0;
            $data['msg']='结束提问';
            echo json_encode($data);die;
        }else{
            $data['code']=1;
            $data['msg']='失败';
            echo json_encode($data);die;
        }
        //根据id 插入回复
    }

}
