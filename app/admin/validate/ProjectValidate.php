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
        'project_abstract' => 'require',
        'project_student' => 'require',
        'project_charge' => 'require',
        'start_time' => 'require',
        'project_people_num' => 'require',

    ];

    protected $message = [
        'project_abstract.require' => '项目摘要不能为空',
        'project_student.require' => '您还未选择主要研究者',
        'project_charge.require' => '您还未选择负责人',
        'start_time.require' => '您还未选择项目开始时间',
        'project_people_num.require' => '您还未填写预期入组人数',
    ];

    protected $scene = [
        'add' => ['project_abstract','project_student','project_charge','start_time'],
        'edit' => ['project_abstract','project_student','project_charge','start_time'],
        'condition' => ['project_people_num'],
    ];
}