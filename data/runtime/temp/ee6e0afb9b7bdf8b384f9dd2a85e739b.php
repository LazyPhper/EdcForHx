<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:50:"themes/admin_simpleboot3/admin\user\user_list.html";i:1550660110;s:81:"D:\phpStudy\PHPTutorial\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1547549958;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/hx/public/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/hx/public/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/hx/public/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/hx/public/static/js/layer/skin/default/layer.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/hx/public/",
            WEB_ROOT: "/hx/public/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/hx/public/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/hx/public/static/js/wind.js"></script>
    <script src="/hx/public/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script src="/hx/public/static/js/layer/layer.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip({
                container:'body',
                html:true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>
</head>
<body>
<div class="wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a>受试者列表</a></li>
        <li ><a href="<?php echo url('user/user_add'); ?>">增加受试者</a></li>
    </ul>
    <form class="well form-inline margin-top-20" method="post" action="<?php echo url('user/adminIndex/index'); ?>">
        用户ID：
        <input class="form-control" type="text" name="uid" style="width: 200px;" value="<?php echo input('request.uid'); ?>"
               placeholder="请输入受试者ID">
        关键字：
        <input class="form-control" type="text" name="keyword" style="width: 200px;" value="<?php echo input('request.keyword'); ?>"
               placeholder="受试者/昵称/邮箱/手机">
        <input type="submit" class="btn btn-primary" value="搜索"/>
        <a class="btn btn-danger" href="<?php echo url('user/adminIndex/index'); ?>">清空</a>
    </form>
    <form method="post" class="js-ajax-form">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>受试者名称</th>
                <th>受试者编号</th>
                <th>加入时间</th>
                <th>中心</th>
                <th>分组</th>
                <th><?php echo lang('STATUS'); ?></th>
                <th><?php echo lang('ACTIONS'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php 
                $user_statuses=array("0"=>lang('USER_STATUS_BLOCKED'),"1"=>lang('USER_STATUS_ACTIVATED'),"2"=>lang('USER_STATUS_UNVERIFIED'));
             if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo !empty($vo['user_login'])?$vo['user_login']:($vo['mobile']?$vo['mobile']:lang('THIRD_PARTY_USER')); ?>
                    </td>
                    <td><?php echo !empty($vo['user_sn'])?$vo['user_sn']:lang('NOT_FILLED'); ?></td>
                    <td><?php echo $vo['create_time']; ?></td>
                    <td><?php echo $vo['center_name']; ?></td>
                    <td><?php echo $vo['group_name']; ?></td>
                    <td><?php echo $crf_status[$vo['crf_status']]; ?></td>
                    <td>
                        <?php if($project_info['project_status']>=2){ ?>
                        <a href='javascript:;' style='color: #CCC'>删除</a>|
                        <a href='javascript:;' style='color: #CCC'><?php echo lang('EDIT'); ?></a>|
                        <a href='javascript:;' style='color: #CCC'>录入</a> |
                        <a href='<?php echo url("user/check_user_crf",array("id"=>$vo["id"])); ?>'>审查</a> |
                        <a href='javascript:;' style='color: #CCC''>签名</a>
                        <?php }else{ ?>
                             <a href='javascript:;' onclick='deleteUser(<?php echo $vo['id']; ?>)'>删除</a>|
                            <a href='<?php echo url("user/user_edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>|
                            <a href='<?php echo url("user/user_crf",array("id"=>$vo["id"])); ?>'>录入</a> |
                            <a href='<?php echo url("user/check_user_crf",array("id"=>$vo["id"])); ?>'>审查</a> |
                            <a href='javascript:;' onclick='updateUserStatus(<?php echo $vo['id']; ?>)'>签名</a>
                        <?php } ?>

                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagination"><?php echo $page; ?></div>
    </form>
</div>
<script src="/hx/public/static/js/admin.js"></script>
</body>
</html>
<script>
function updateUserStatus(user_id)
{
	var param='?crf_status=4&user_id='+user_id;
			var url="<?php echo url('admin/user/sign'); ?>";
			// alert(url);
		    layer.open({
		      type: 2,
		      title: '签名',
		      shadeClose: true,
		      shade: false,
		      maxmin: true, //开启最大化最小化按钮
		      area: ['893px', '600px'],
		      content: url+param
		    });
}

function deleteUser(user_id)
    {

            //询问框
                layer.confirm('您确定要删除该受试者？', {
                  btn: ['确定','取消'] //按钮
                }, function(){
                    //确定
                    $.ajax({  
                            type:"post",  
                            url:"<?php echo url('admin/user/userdelete'); ?>",  
                            data:{id:user_id},//这里data传递过去的是序列化以后的字符串 
                            dataType:'json',
                            success:function(data){  
                                if(data.code==0)
                                {
                                     layer.msg('删除成功', {time: 1500, icon:6});
                                     location.reload();
                                }else{
                                     layer.msg('删除失败', {time: 1500, icon:6});
                                }
                               
                            }  
                    });  
                  
                },
                //取消
                 function(){
                  layer.msg('已取消');
                });
 
    }


</script>