<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"G:\PHPTutorial\WWW\hx\public/plugins/wxapp/view/admin_wxapp\add.html";i:1535858921;s:64:"G:\PHPTutorial\WWW\hx\public\plugins\wxapp\view\public\head.html";i:1535858921;s:67:"G:\PHPTutorial\WWW\hx\public\plugins\wxapp\view\public\scripts.html";i:1535858921;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">

<!-- No Baidu Siteapp-->
<meta http-equiv="Cache-Control" content="no-siteapp"/>

<link rel="shortcut icon" href="/hx/public/plugins/wxapp/view/public/assets/images/favicon.ico" type="image/x-icon">

<link href="/hx/public/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
<link href="/hx/public/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
<link href="/hx/public/static/font-awesome/css/font-awesome.min.css?page=index" rel="stylesheet" type="text/css">

<script type="text/javascript">
    //全局变量
    var GV = {
        ROOT: "/hx/public/",
        WEB_ROOT: "/hx/public/",
        JS_ROOT: "static/js/"
    };
</script>
    <title>ThinkCMF插件演示首页</title>
    <meta name="description" content="ThinkCMF插件演示首页">
    <meta name="keywords" content="ThinkCMF插件演示首页">
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo cmf_plugin_url('Wxapp://AdminIndex/index'); ?>">小程序管理</a></li>
        <li class="active"><a href="<?php echo cmf_plugin_url('Wxapp://AdminWxapp/add'); ?>">添加小程序</a></li>
    </ul>
    <form method="post" class="form-horizontal js-ajax-form margin-top-20"
          action="<?php echo cmf_plugin_url('Wxapp://AdminWxapp/addPost'); ?>">

        <div class="form-group">
            <label class="col-sm-2 control-label"><span class="form-required">*</span>名称</label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" name="name" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><span class="form-required">*</span>App ID</label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" name="app_id" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><span class="form-required">*</span>App Secret</label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" name="app_secret" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">默认小程序</label>
            <div class="col-md-6 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="is_default" value="1">
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang("SAVE"); ?></button>
        </div>
    </form>
</div>
<script src="/hx/public/static/js/jquery.js"></script>
<script src="/hx/public/static/js/wind.js"></script>
<script src="/hx/public/static/js/bootstrap.min.js"></script>
<script src="/hx/public/static/js/admin.js"></script>
</body>
</html>