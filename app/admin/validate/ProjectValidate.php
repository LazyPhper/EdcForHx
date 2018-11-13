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

class ProjectValidate extends Validate
{
    protected $rule = [
        'project_name'  => 'require',
        'project_sn' => 'require|unique:admin_project',
        'project_charge' => 'require',
        'project_abstract' => 'require',
        'project_student' => 'require',
        'accredit' => 'require'
    ];
    protected $message = [
        'project_sn.require' => '项目编号不能为空',
        'project_sn.unique'  => '项目编号已存在',
        'project_name.require'  => '项目名称不能为空',
        'project_charge.require' => '负责人为不能为空',
        'project_student.require'   => '主要研究者不能为空',
        'accredit.require'  => '授权操作用户不能为空',
    ];

    protected $scene = [
        'add'  => ['project_name', 'project_sn', 'project_charge', 'project_abstract', 'project_student', 'accredit']
    ];
}