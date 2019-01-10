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
namespace app\admin\validate;

use think\Validate;

class CenterValidate extends Validate
{
    protected $rule = [
        'center_name' => 'require',
        'center_sn' => 'require',
        'admin_id' => 'require',
        'checked_time' => 'require',
        'center_start_date' => 'require',
        'center_number' => 'require',

    ];

    protected $message = [
        'center_name.require' => '中心名称不能为空',
        'admin_id.require' => '您还未选择主要研究者',
        'center_sn.require' => '中心编号不能为空',
        'checked_time.require' => '方案通过伦理审查日期不为空',
         'center_start_date.require' => '启动日期不为空',
        'center_number.require' => '您还未填写预期入组人数',
    ];

    protected $scene = [
        'add' => ['center_name','admin_id','center_sn','checked_time','center_start_date','center_number'],
        'edit' => ['center_name','admin_id','center_sn','checked_time','center_start_date','center_number'],
       
    ];
}