<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;

class ProjectModel extends Model
{
    protected $name = 'm_project';
    protected $pk = 'id';

    protected $type = [
        'more' => 'array',
    ];

    public function user() {
        // Profile模型和当前模型的命名空间不一致
        return $this->hasOne('userModel','id','create_people');
    }
    public function principal() {
        // Profile模型和当前模型的命名空间不一致
        return $this->hasOne('userModel','id','principal');
    }

}