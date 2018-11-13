<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:45:"themes/admin_simpleboot3/admin\route\add.html";i:1535858921;s:72:"G:\PHPTutorial\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1535858921;}*/ ?>
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
<div class="wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo url('route/index'); ?>">URL美化</a></li>
        <li class="active"><a href="<?php echo url('route/add'); ?>">添加URL规则</a></li>
    </ul>
    <form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('route/addPost'); ?>">
        <div class="form-group">
            <label for="input-full_url" class="col-sm-2 control-label">原始网址<span class="form-required">*</span></label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" id="input-full_url" name="full_url"> <a href="javascript:doSelectUrl();">选择规则</a>
            </div>
        </div>
        <div class="form-group">
            <label for="input-url" class="col-sm-2 control-label">显示网址<span class="form-required">*</span></label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" id="input-url" name="url">
                <p class="help-block"><span id="url-vars"></span> url格式一般为list/:param1/:param2或 list-&lt;param1&gt;-&lt;param2&gt;
                </p>
            </div>
        </div>
        <div class="form-group">
            <label for="input-status" class="col-sm-2 control-label">是否启用</label>
            <div class="col-md-6 col-sm-10">
                <select class="form-control" name="status" id="input-status">
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('SAVE'); ?></button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/hx/public/static/js/admin.js"></script>

<script>
    function doSelectUrl() {
        var selectedCategoriesId = $('#js-categories-id-input').val();
        openIframeLayer("<?php echo url('Route/select'); ?>?ids=" + selectedCategoriesId, '请选择URL', {
            area: ['95%', '90%'],
            btn: ['确定', '取消'],
            yes: function (index, layero) {

                var iframeWin   = window[layero.find('iframe')[0]['name']];
                var selectedUrl = iframeWin.confirm();

                if (selectedUrl) {
                    $('#input-full_url').val(selectedUrl.action);
                    $('#input-url').val(selectedUrl.url);
                    var helpBlock = selectedUrl.vars ? "URL参数有" + selectedUrl.vars + ',' : '';
                    $('#url-vars').text(helpBlock);
                }
                layer.close(index); //如果设定了yes回调，需进行手工关闭
            }
        });
    }
</script>
</body>
</html>