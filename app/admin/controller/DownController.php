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
use Dompdf\Dompdf;

class DownController extends AdminBaseController
{

    public function _initialize()
    {
        parent::_initialize();
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
        $start_time=strtotime($start_time);
        $end_time=strtotime($end_time);
        if($start_time>$end_time)
        {
            $time=$end_time;
            $end_time=$start_time;
            $start_time=$end_time;
        }
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
                                $tableName.=implode('|',$v).chr(10);
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
                                    $tableName.=$event_desc['option'][$k].chr(10);
                                }
                                $objPHPExcel->getActiveSheet()->getStyle($le.$num)->getAlignment()->setWrapText(true);
                                
                            }
                            
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
       
        //设置工作表标题
        $objPHPExcel->getActiveSheet()->setTitle($project_info['project_name']);
        //设置列的宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $np=$project_info['project_name'].date('Y-m-d').rand(100,999);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=".$np.".xlsx");//设置文件标题
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }  

    /**
    *pdf
    */
    //打印输出pdf
public function printContract(){
        // vendor('TCPDF-master.examples.config.tcpdf_config_alt');
        vendor('TCPDF.tcpdf');
        $letter=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // 设置打印模式
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('郑州弘新医疗');
        $pdf->SetTitle('郑州弘新医疗');
        $pdf->SetSubject('郑州弘新医疗');
        $pdf->SetKeywords('郑州弘新医疗, PDF,');
        // 是否显示页眉
        $pdf->setPrintHeader(false);
        // 设置页眉显示的内容
        $pdf->SetHeaderData('logo.png', 60, 'edc.cmdct.com', '郑州弘新医疗', array(0,64,255), array(0,64,128));
        // 设置页眉字体
        $pdf->setHeaderFont(Array('dejavusans', '', '12'));
        // 页眉距离顶部的距离
        $pdf->SetHeaderMargin('5');
        // 是否显示页脚
        $pdf->setPrintFooter(true);
        // 设置页脚显示的内容
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        // 设置页脚的字体
        $pdf->setFooterFont(Array('dejavusans', '', '10'));
        // 设置页脚距离底部的距离
        $pdf->SetFooterMargin('10');
        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // 设置行高
        $pdf->setCellHeightRatio(1);
        // 设置左、上、右的间距
        $pdf->SetMargins('10', '10', '10');
        // 设置是否自动分页  距离底部多少距离时分页
        $pdf->SetAutoPageBreak(true, '15');
        // 设置图像比例因子
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->AddPage();
        // 设置字体
        //根据project_id
        $project_id=$this->request->param('project_id');
        $ids=$this->request->param('ids');
        $start_time=$this->request->param('start_time');
        $end_time=$this->request->param('end_time');
        $k='';
        $start_time=strtotime($start_time);
        $end_time=strtotime($end_time);
        if($start_time>$end_time)
        {
            $time=$end_time;
            $end_time=$start_time;
            $start_time=$end_time;
        } 
        //
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
        $result=Db::name('admin_project_crf')->where($where)->order('event_num asc , sort asc')->select();
        //将crf结果格式化
        $crf_result=array();
        foreach($result as $k=>$v)
        {
           $crf_result[$v['event_num']][]=$v;
        }

         //先查出用户列表
        $where_u['u.create_time']=array('gt',$start_time);
        $where_u['u.create_time']=array('lt',$end_time);
        $where_u['user_type']=2;
        $where_u['u.project_id']=$project_id;
        $user_list=Db::name('user')
                ->alias('u')
                ->field('u.id,user_login,user_sn,u.create_time,c.center_name')
                ->join('center c','c.id=u.center_id')
                ->where($where_u)
                ->select();
        $crf=[];
        $html='';
        $allhtml='<style>
        .div_title{margin-top:10px;height: 35px;line-height: 35px;font-size: medium;text-align: center} 
        .table_border{margin:0 auto;border: 1px solid #95a5a6;margin-top: 8px;}
        .td_border{height:35px;text-align: center}
        .m-top{margin-top:3%;}
    </style>';
        foreach ($user_list as $uk=>$uv)
        {
            $crf=$this->userCrf($project_id,$uv['id']);
            $html='<div class="tabCon"><div class="div_title">'.$uv['user_sn'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$uv['user_login'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$uv['center_name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('Y-m-d',$uv['create_time']).'</div>';
                foreach ($crf_result as $k => $value) {
                        foreach ($value as $kkk => $v) {
                                //标题
                             if($v['event_type']=='title')
                                {
                                    $html.='<div class="div_title">'.$v['event_desc'].'</div>';
                                }
                                //选择
                                if($v['event_type']=='input')
                                {   
                                    if($v['event_type_t']=='fill'){
                                        if(!empty($crf))
                                        {
                                           
                                            if(empty($crf[$v['id']]))
                                            {
                                                $vv='';
                                            }else{
                                                 $vv=$crf[$v['id']]['crf_desc'];
                                            }

                                        }else{
                                            $vv='';
                                        }
                                         $html.='<div class="div_input">'.$v['event_desc'].'&nbsp;&nbsp;&nbsp;<u>'.$vv.'</u>';
                                    }elseif($v['event_type_t']=='date'){
                                        if(!empty($crf))
                                        {
                                            if(empty($crf[$v['id']]))
                                            {
                                                $vv='';
                                            }else{
                                                 $vv=$crf[$v['id']]['crf_desc'];
                                            }
                                        }else{
                                            $vv='';
                                        }
                                        $html.='<div class="div_input">'.$v['event_desc'].'&nbsp;&nbsp;&nbsp;&nbsp;<u>'.$vv.'</u>';

                                    }elseif($v['event_type_t']=='desc'){
                                            $html.='<div class="div_input"><span class="form-required">*</span>'.$v['event_desc'].'</div>';

                                    }

                                 }
                                 //选择
                                  if($v['event_type']=='select')
                                  {
                                    $select=json_decode($v['event_desc'],true);
                                    $html.='<div class="div_select"><span>'.$select['name'].'</span><div class="select_div">';
                                        foreach ($select['option'] as $select_k => $sel) 
                                        {
                                            # code...
                                            $html.='<div class="option_div"><span>'.$letter[$select_k].'</span>:&nbsp;&nbsp;';
                                            if(isset($crf[$v['id']]))
                                            {
                                             $de=$crf[$v['id']]['crf_desc']; 
                                            } 
                                            $html.='<span class="select_input">'.$sel.'</span>';
                                            if($v['event_type_t']=='radio')
                                            {
                                                    if(isset($de))
                                                    {
                                                        if($de==$letter[$select_k])
                                                        {
                                                            $html.='√';
                                                        }else{
                                                            $html.='';
                                                        }
                                                    }else{
                                                         $html.='';
                                                    }

                                            }else{
                                                if(isset($crf[$v['id']]))
                                                    { 
                                                        $de=$crf[$v['id']]['crf_desc'];
                                                        $dearray=json_decode($de,true);
                                                     }else{ 
                                                        $dearray=array();
                                                    }
                                                    if(in_array($letter[$select_k], $dearray))
                                                    { 
                                                         $html.='√';
                                                    }else{
                                                        $html.='';
                                                    }
                                            }
                                            $html.='</div>';
                                            

                                        }
                   
                                    }

                                    //表格
                                    if($v['event_type']=='table')
                                    {
                                        $table=json_decode($v['event_desc'],true);
                                        $html.=' <div class="div_select"> <span>'.$table['name'].'</span><br><table style="border:2" class="table_border">
                                            <tr>';
                                            foreach($table['desc']as $table_k=>$tab)
                                            {
                                                $html.='<td class="td_border">'.$tab.'</td>';
                                            }
                                        $html.='</tr>';
                                        if(!isset($crf[$v['id']]))
                                        {
                                           
                                            $html.='<tr>';
                                            foreach ($table['type'] as $table_k => $tab_t) 
                                            {
                                                if($tab_t=='text')
                                                {
                                                    $html.='<td class="td_border"></td>';
                                                }elseif($tab_t=='date'){
                                                    $html.='<td class="td_border"></td>';
                                                }elseif($tab_t=='radio_or'){
                                                    $html.=' <td class="td_border">是&nbsp;&nbsp;否</td>';
                                                }else{
                                                    $html.='<td class="td_border"></td>';
                                                }
                                            }
                                            $html.='</tr>';
                                        }else{
                                            if(isset($crf[$v['id']]))
                                            {
                                                $desc=$crf[$v['id']];
                                                $crf_desc=$desc['crf_desc'];
                                                $des=json_decode($crf_desc,true);
                                            }else{
                                                $des=array();
                                            }
                                            foreach($des as $kk => $value) {
                                                # code...
                                                 $html.='<tr>';
                                                 foreach ($table['type'] as $table_k => $tab_t) 
                                                 {
                                                    if(isset($value[$table_k])){ $dd=$value[$table_k]; }else{ $dd=''; }
                                                     if($tab_t=='text')
                                                        {
                                                            $html.='<td class="td_border">'.$dd.'</td>';
                                                     
                                                        }elseif($tab_t=='date'){
                                                            $html.='<td class="td_border">'.$dd.'</td>';
                                                        }elseif($tab_t=='radio_or'){
                                                            if($dd==1){
                                                                 $html.='<td class="td_border"> √ 是&nbsp;&nbsp;&nbsp;否</td>';
                                                             }elseif($dd==2){
                                                                 $html.='<td class="td_border">是&nbsp;&nbsp;&nbsp;√否</td>';
                                                             }else{
                                                                $html.='<td class="td_border"> 是&nbsp;&nbsp;&nbsp;否</td>';
                                                             }
                                                           
                                                        }else{
                                                         $html.='<td class="td_border">'.$dd.'</td>';
                                                        }
                                                 }
                                                 $html.='</tr>';
                                    
                                            }
                                         
             
                                        }//else end

                                    }//if == table end

                    }

                }
                $html.='<hr><div class="m-top"></div>';
                $allhtml.=$html;
        }

        

        
 
        $pdf->SetFont('stsongstdlight', '', 14, '', true);
        $pdf->writeHTMLCell(0, 0, '', '', $allhtml, 0, 1, 0, true, '', true);
        $pdf->Output('example_001.pdf', 'I');

    }


    public function userCrf($project_id,$user_id)
    {
        $crf_status=array('0'=>'未录入','1'=>'首次录入','2'=>'二次录入','3'=>'录入完成','4'=>'签名',);
        $project_info=Db::name('admin_project')
                ->where(['id'=>$project_id])
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

        return $new_crf;
    }
    





}
