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
        }
        //已的提问
        $where['status']=1;
        $where['respone_status']=0;
        $count = Db::name('user_ask')
            ->where($where)
            ->count();
        $this->assign("count", $count);
         //已的提问
        $where['status']=1;
        $where['respone_status']=1;
        $count_ask = Db::name('user_ask')
            ->where($where)
            ->count();
        $this->assign("count_ask", $count_ask);

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
            $where['respone_id']=$admin_id;
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
            $where['admin_id']=$admin_id;
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

    //回复
    public function answer()
    {
        $request = $this->request->param();
        $id=$request['id'];
        $answer=$request['answer'];
        $where['id']=$id;
        $ask_info=Db::name('user_ask')->where($where)->find();
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
        $save['respone_status']=1;
        $save['status']=2;
        $result=Db::name('user_ask')->where($where)->update($save);
        if($result)
        {
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
