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
        // $user = Db::query("select * from cmf_user");
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
        $end_time=$this->request->param('end_time');
        $k='';

        // $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true);
        // for($i=0;$i<=200;$i++)
        // {
             
        //      if(!($i%26))
        //      {
        //         $key=$i/26;
        //         if($key==0)
        //         {
        //             $k='';
        //         }else{
        //             $kkk=$key-1;
        //             $k=$letter[$kkk];
        //         }
        //      }
        //      if($i<26)
        //      {
        //         $kk=$i;
        //      }else{
        //         $ky=$i%26;
        //         $kk=$ky;
        //     }

        //      echo $k.$letter[$kk];
        // }
  
        $project_info=Db::name('admin_project')->field('project_name')->where(['id'=>$project_id])->find();
        $where=[];
        //根据ids 查出所有crf
        $where_c=[];
        $where_c['id']=array('in',$ids);
        $where_c['sort']=0;
        $project_crf_list=Db::name('admin_project_crf')->field('project_id,event_num')->where($where_c)->select();
        
        $project_crf_event='';
        foreach ($project_crf_list as $key => $value) {
            $project_crf_event.=$value['event_num'].',';
        }
        //event
        $project_crf_event=trim($project_crf_event,',');
        $where['event_num']=array('in',$project_crf_event);
        $where['project_id']=$project_id;
        $where['event_type_t']=array('in','fill,date,radio,checkbox,table');
        //所有crf
        $project_crf=Db::name('admin_project_crf')->field('id,event_desc,event_type,event_type_t')->where($where)->order('event_num asc , sort asc')->select();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '用户编码');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1', '用户姓名');
        foreach($project_crf as $i=>$v)
        {
            $i=$i+2;
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
            $le=$k.$letter[$kk].'1';
            $tableName='';
            if($v['event_type']=='table')
            {
                $name=json_decode($v['event_desc'],true);
                $desc=$name['desc'];
                $tableName=implode('|',$desc);
            }elseif($v['event_type']=='select'){
                $name=json_decode($v['event_desc'],true);
                $tableName=$name['name'];
            }else{
                $tableName=$v['event_desc'];
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($le, $tableName);
        }
        //先查出用户列表
        $where_u['create_time']=array('gt',$start_time);
        $where_u['create_time']=array('lt',$end_time);
        $where_u['user_type']=2;
        $where_u['project_id']=$project_id;
        $user_list=Db::name('user')->field('id,user_login,user_sn')->where($where_u)->select();
        // print_r($user_list);die;
        foreach ($user_list as $kal => $value) {
            $num=$kal+2;
            $list=Db::name('admin_user_crf')
                    ->alias('uc')
                    ->field('uc.*,pc.event_type,pc.event_type_t,pc.event_desc')
                    ->join('admin_project_crf pc','pc.id=uc.crf_id')
                    ->where([
                        'pc.event_num'=>['in',$project_crf_event],
                        'uc.project_id'=>$project_id,
                        'pc.event_type_t'=>['in','fill,date,radio,checkbox,table'],
                        'uc.user_id'=>$value['id']
                        ])
                    ->order('pc.event_num asc,pc.sort asc')
                    ->select();

                foreach ($list as $i => $val) {
                    $wherep=[];
                    $k='';
                    $kk='';
                    $i=$i+2;
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

                    $le=$k.$letter[$kk];
                        $tableName='';
                        if($val['event_type']=='table')
                        {
                            $desc=json_decode($val['crf_desc'],true);
                            foreach($desc as $k=>$v)
                            {
                                $tableName.="".implode('|',$v)."/r/n";
                            }
                            $objPHPExcel->getActiveSheet()->getStyle($le.$num)->getAlignment()->setWrapText(true);
                           
                        }elseif($val['event_type']=='select'){
                            if($val['event_type_t']=='radio')
                            {
                                //
                                $tableName='';
                                $event_desc=json_decode($val['event_desc'],true);
                                $k=array_search($val['crf_desc'],$letter);
                                $tableName=$event_desc['option'][$k];

                            }
                            if($val['event_type_t']=='checkbox')
                            {
                                //
                                $tableName='';
                                $event_desc=json_decode($val['event_desc'],true);
                                $res=json_decode($val['crf_desc']);
                                foreach($res as $k=>$v)
                                {
                                    $k=array_search($v,$letter);
                                    $tableName.=$event_desc['option'][$k]."/r/n";
                                }
                                $objPHPExcel->getActiveSheet()->getStyle($le.$num)->getAlignment()->setWrapText(true);
                                
                            }
                            $desc=json_decode($val['crf_desc'],true);
                            $tableName=$name['name'];
                        }else{
                            $tableName=$val['crf_desc'];
                        }
                         $objPHPExcel->setActiveSheetIndex(0)
                           ->setCellValue('A'.$num, $value['user_sn']);
                            $objPHPExcel->setActiveSheetIndex(0)
                           ->setCellValue('B'.$num, $value['user_login']);

                        $objPHPExcel->setActiveSheetIndex(0)
                           ->setCellValue($le.$num, $tableName);

                        

                }

        }
       


        // $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A1', 'ID')
        //     ->setCellValue('B1', '用户名')
        //     ->setCellValue('C1', '密码')
        //     ->setCellValue('D1', '标志');
        //     $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('E1', 'ID');
        //存取数据  这边是关键
        // foreach ($project_crf as $i => $value) {
        //     $wherep=[];
        //     $num = $i + 2;
        //     if(!($i%26))
        //      {
        //         $key=$i/26;
        //         if($key==0)
        //         {
        //             $k='';
        //         }else{
        //             $kkk=$key-1;
        //             $k=$letter[$kkk];
        //         }
        //      }
        //      if($i<26)
        //      {
        //         $kk=$i;
        //      }else{
        //         $ky=$i%26;
        //         $kk=$ky;
        //     }

        //     $le=$k.$letter[$kk];
            # code...
            // $info=Db::name('admin_user_crf')->field('uc.*')
            //     ->alias('uc')
            //     ->join('user u','u.id=uc.user_id')
            //     ->where([
            //         'uc.crf_id'=>$value['id'],
            //         'u.create_time'=>['gt',$start_time],
            //         'u.create_time'=>['lt',$end_time]
            //         ])
            //     ->find();
            //  $num = $i + 2;
            //  if(empty($info))
            //  {
            //     $objPHPExcel->setActiveSheetIndex(0)
            //        ->setCellValue($le . $num, '');
            //  }else{
            //     $tableName='';
            //     if($value['event_type']=='table')
            //     {
            //         $desc=json_decode($info['crf_desc'],true);
            //         foreach($desc as $k=>$v)
            //         {
            //             $tableName.=implode('|',$v).'/n';
            //         }
                   
            //     }elseif($value['event_type']=='select'){
            //         if($value['event_type_t']=='radio')
            //         {
            //             //
            //             $tableName='';
            //             $event_desc=json_decode($value['event_desc'],true);
            //             $k=array_search($info['crf_desc'],$letter);
            //             $tableName=$event_desc['option'][$k];
            //         }
            //         if($value['event_type_t']=='checkbox')
            //         {
            //             //
            //             $tableName='';
            //             $event_desc=json_decode($value['event_desc'],true);
            //             $res=json_decode($info['crf_desc']);
            //             foreach($res as $k=>$v)
            //             {
            //                 $k=array_search($v,$letter);
            //                 $tableName.=$event_desc['option'][$k].'/n';
            //             }
                        
            //         }
            //         $desc=json_decode($info['crf_desc'],true);
            //         $tableName=$name['name'];
            //     }else{
            //         $tableName=$info['crf_desc'];
            //     }
            //     $objPHPExcel->setActiveSheetIndex(0)
            //        ->setCellValue($le.$num, $tableName);

            //  }
              
        //       echo $num.'//';
            
        // }
        // die;
        // foreach ($user as $k => $v) {
        //     $num = $k + 2;
        //     $objPHPExcel->setActiveSheetIndex(0)
        //         ->setCellValue('A' . $num, $v['id'])
        //         ->setCellValue('B' . $num, $v['user_login'])
        //         ->setCellValue('C' . $num, $v['user_pass'])
        //         ->setCellValue('D' . $num, $v['group']);
        // }
        //设置工作表标题
        $objPHPExcel->getActiveSheet()->setTitle($project_info['project_name']);
        //设置列的宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $np=$project_info['project_name'].date('Y-m-d').round(100,999);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=".$np.".xlsx");//设置文件标题
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }  



}
