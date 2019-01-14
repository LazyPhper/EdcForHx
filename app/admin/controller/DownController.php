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
use think\Loader;

class DownController extends AdminBaseController
{

    public function _initialize()
    {
        parent::_initialize();
        //$this->action 访问url
    }

    /**
     * 导出选择页
     */
    public function index()
    {
        $admin_id=$_SESSION['think']['ADMIN_ID'];
        //根据admin_id 查出project_id 受试者user_id
        $user_info=Db::name('user')->where(['id'=>$admin_id])->find();
        $project_id=$user_info['project_id'];
        $center_id=$user_info['center_id'];
        //项目信息
        $crf_list= [];
        if($admin_id==1)
        {
            $project_list=Db::name('admin_project')->where(['id'=>$project_id])->select();
            $crf_list= [];
        }else{
            $project_list=Db::name('admin_project')->where(['id'=>$project_id])->select();
           
        }
         $crf_list=Db::name('admin_project_crf')->field('*')->where(['event_type'=>'title','sort'=>0,'project_id'=>$project_id])->select();

        //查出项目的 crf
        $this->assign('project_list',$project_list);
        $this->assign('crf_list',$crf_list);
        return $this->fetch();
    }

    /**
     * 将数据库数据导出为excel文件
     */
    function down()
    {
        $user = Db::query("select * from cmf_user");
        Loader::import('PHPExcel.PHPExcel');
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory');
        Loader::import('PHPExcel.PHPExcel.Reader.Excel2007');
        $objPHPExcel = new \PHPExcel();
        //设置每列的标题
        //设置A1-Z1 AA1-AZ1
        $letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $project_id=$this->request->param('project_id');
        $ids=$this->request->param('ids');
        $start_time=$this->request->param('start_time');
        $start_time=$this->request->param('end_time');
        $k='';
        for($i=0;$i<=200;$i++)
        {
             
             if(!($i%26))
             {
                $key=$i/26;
                if($key==0)
                {
                    $k='';
                }else{
                    $kkk=$key-1;
                    $k=$letter[$kkk];
                }
             }
             if($i<26)
             {
                $kk=$i;
             }else{
                $ky=$i%26;
                $kk=$ky;
             }



             echo $k.$letter[$kk];

             
        }
        die;

        // $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A1', 'ID')
        //     ->setCellValue('B1', '用户名')
        //     ->setCellValue('C1', '密码')
        //     ->setCellValue('D1', '标志');
        //     $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('E1', 'ID');
        //存取数据  这边是关键
        foreach ($user as $k => $v) {
            $num = $k + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $num, $v['id'])
                ->setCellValue('B' . $num, $v['user_login'])
                ->setCellValue('C' . $num, $v['user_pass'])
                ->setCellValue('D' . $num, $v['group']);
        }
        //设置工作表标题
        $objPHPExcel->getActiveSheet()->setTitle('我的文档');
        //设置列的宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=用户信息.xlsx");//设置文件标题
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }  



}
