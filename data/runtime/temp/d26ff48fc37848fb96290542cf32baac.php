<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:48:"themes/admin_simpleboot3/admin\nav_menu\add.html";i:1535858921;s:72:"G:\PHPTutorial\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1535858921;}*/ ?>
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
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo url('NavMenu/index',['nav_id'=>$nav_id]); ?>">导航菜单</a></li>
        <li class="active"><a><?php echo lang('ADMIN_MENU_ADD'); ?></a></li>
    </ul>

    <form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('NavMenu/addPost'); ?>">
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label">上级:</label>
                <div class="col-md-6 col-sm-10">
                    <select name="parent_id" class="form-control">
                        <option value="0">/</option>
                        <?php echo $nav_trees; ?>
                    </select>
                </div>
            </div>
            <div class="form-group form-inline">
                <label class="col-sm-2 control-label"><span class="form-required">*</span>地址:</label>
                <div class="col-md-6 col-sm-10">
                    <input type="radio" id="external-link-radio">
                    <input type="text" class="form-control" name="href" id="external-link-input">
                    <input type="radio" id="select-href-radio">
                    <select name="href" id="select-href" class="form-control">
                        <option value="<?php echo base64_encode('home'); ?>" data-name="首页">首页</option>
                        <?php if(is_array($navs) || $navs instanceof \think\Collection || $navs instanceof \think\Paginator): if( count($navs)==0 ) : echo "" ;else: foreach($navs as $key=>$vo): ?>
                            <optgroup label="<?php echo $vo['name']; ?>">
                                <?php echo $vo['html']; ?>
                            </optgroup>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><span class="form-required">*</span>菜单名称:</label>
                <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" name="name" id="name-input">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">打开方式:</label>
                <div class="col-md-6 col-sm-10">
                    <select class="form-control" name="target">
                        <option value="">默认方式</option>
                        <option value="_blank">新窗口打开</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">图标:</label>
                <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" name="icon" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">显示:</label>
                <div class="col-md-6 col-sm-10">
                    <select name="status" class="form-control">
                        <option value="1">显示</option>
                        <option value="0">隐藏</option>
                    </select>
                </div>
            </div>
        </fieldset>

        <div class="col-sm-offset-2 col-sm-10">
            <input type="hidden" name="nav_id" value="<?php echo $nav_id; ?>"/>
            <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang("SAVE"); ?></button>
            <a class="btn btn-default" href="<?php echo url('NavMenu/index',['nav_id'=>$nav_id]); ?>">返回</a>
        </div>
    </form>

</div>
<script src="/hx/public/static/js/admin.js"></script>
<script>
    $(function () {
        $("#select-href,#select-href-radio").click(function () {
            checkChange(2);
        });

        $("#select-href").change(function () {
            var $this = $(this);
            var label = $this.find("option[value='" + $this.val() + "']").data('name');
            $('#name-input').val(label);
        });

        $("#external-link-input,#external-link-radio").click(function () {
            checkChange(1);
        });

        function checkChange(i) {
            if (i == 1) {
                //自动输入url
                $('#external-link-input').attr('name', 'external_href');
                $('#select-href').removeAttr('name');
                $('#select-href-radio').prop('checked', false);
                $('#external-link-radio').prop('checked', true);
            } else {
                //选择链接url
                $('#select-href').attr('name', 'href');
                $('#external-link-input').removeAttr('name');
                $('#select-href-radio').prop('checked', true);
                $('#external-link-radio').prop('checked', false);
            }
        }
    });
</script>
</body>
</html>
