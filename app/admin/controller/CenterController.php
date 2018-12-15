<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:kane < chengjin005@163.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;

/**
 * Class CenterController 医院中心管理控制器
 * @package app\portal\controller
 */
class CenterController extends AdminBaseController
{

    
    
    public function index()
    {
            $arrStatus = array(
            0=>"未启用",
            1=>"已启用",
        );
        $content = hook_one('admin_user_index_view');

        if (!empty($content)) {
            return $content;
        }
        $where=[];
        /**搜索条件**/
        $status = $this->request->param('status');
        $keywords = trim($this->request->param('keywords'));

        if ($status) {
            $where['user_login'] = $status;
        }

        if ($keywords) {
            $where['keywords'] = ['like', "%$keywords%"];;
        }
        $list = Db::name('center')
            ->where($where)
            ->order("id DESC")
            ->paginate(10);
        $list->appends(['status' => $status, 'keywords' => $keywords]);
        // 获取分页显示
        $page = $list->render();
        $this->assign("page", $page);
        $this->assign("arrStatus", $arrStatus);
        $this->assign("list", $list);
        return $this->fetch();
    }

    /**
     * 添加文章标签
     */
    public function add()
    {
        $arrStatus = array(
        0=>"未启用",
        1=>"已启用",
    );
         $this->assign("arrStatus", $arrStatus);
        return $this->fetch();
    }

    /**
     * 添加中心提交
     *
     * )
     */
    public function addPost()
    {

        $arrData = $this->request->param();
        $result  = DB::name('center')->insertGetId($arrData);
        if($result)
        {
            $this->success("添加成功！");
        }else{
            $this->error("添加失败！");
        }

    }

    /**
     * 更新中心
     */
    public function upStatus()
    {
        $intId     = $this->request->param("id");
        $intStatus = $this->request->param("status");
        $intStatus = $intStatus ? 1 : 0;
        if (empty($intId)) {
            $this->error(lang("NO_ID"));
        }
        $result = DB::name('center')->where(["id" => $intId])->update(["status" => $intStatus]);
        if($result)
        {
            $this->success("更新成功！");
        }else{
            $this->error("更新失败！");
        }
       
    }

    /**
     * 删除中心
     */
    public function delete()
    {
        $intId = $this->request->param("id", 0, 'intval');

        if (empty($intId)) {
            $this->error(lang("NO_ID"));
        }
        $result =DB::name('center')->where(['id' => $intId])->delete();
        
        if($result)
        {
            $this->success("更新成功！");
        }else{
            $this->error("更新失败！");
        }
    }
}
