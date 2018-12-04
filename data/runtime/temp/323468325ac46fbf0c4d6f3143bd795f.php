<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:50:"themes/admin_simpleboot3/admin\user\user_edit.html";i:1541056916;s:72:"G:\PHPTutorial\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1540550792;}*/ ?>
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
			<li><a href="<?php echo url('user/user_list'); ?>">受试者列表</a></li>
			<li><a href="<?php echo url('user/user_edit'); ?>">添加受试者</a></li>
			<li class="active"><a>编辑受试者</a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('admin/user/adduserpost'); ?>">
			<div class="form-group">
				<label for="input-user_login" class="col-sm-2 control-label"><span class="form-required">*</span>受试者姓名</label>
				<div class="col-md-5 col-sm-10">
					<input class="form-control" id="input-user_login" type="text" name="post[user_login]"
						   value="<?php echo $info['user_login']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="input-user_sn" class="col-sm-2 control-label"><span class="form-required">*</span>受试者编号</label>
				<div class="col-md-5 col-sm-10">
					<input class="form-control" id="input-user_sn" type="text" name="post[user_sn]"
						   value="<?php echo $info['user_sn']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="input-add_time" class="col-sm-2 control-label"><span class="form-required">*</span>加入时间</label>
				<div class="col-md-5 col-sm-10">
					<input class="form-control js-date" id="input-add_time" type="text" name="post[create_time]"
						   value="<?php echo $info['create_time']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="more-template-select" class="col-sm-2 control-label"><span class="form-required">*</span>性别</label>
				<div class="col-md-5 col-sm-10">
					<select class="form-control" name="post[sex]" id="more-template-select">
						<option value="1" <?php if($info['sex']==1){echo 'selected';} ?> >男</option>
						<option value="2" <?php if($info['sex']==2){echo 'selected';} ?> >女</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="input-birthday_time" class="col-sm-2 control-label"><span class="form-required">*</span>出生日期</label>
				<div class="col-md-5 col-sm-10">
					<input class="form-control js-date" id="input-birthday_time" type="text" name="post[birthday]"
						   value="<?php echo $info['birthday']; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="more-group-select" class="col-sm-2 control-label"><span class="form-required">*</span>受试者分组</label>
				<div class="col-md-5 col-sm-10">
					<select class="form-control" name="post[group]" id="more-group-select">
						<option value="1" <?php if($info['group']==1){echo 'selected';} ?> >对照组</option>
						<option value="2" <?php if($info['group']==2){echo 'selected';} ?> >受试组</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="input-start_time" class="col-sm-2 control-label"><span class="form-required">*</span>开始日期</label>
				<div class="col-md-5 col-sm-10">
					<input class="form-control js-date" id="input-start_time" type="text" name="post[start_time]"
						   value="<?php echo $info['start_time']; ?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('SAVE'); ?></button>
				</div>
			</div>
		</form>
	</div>
	<script src="/hx/public/static/js/admin.js"></script>
</body>
</html>