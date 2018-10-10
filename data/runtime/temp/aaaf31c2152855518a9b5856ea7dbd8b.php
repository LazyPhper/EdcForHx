<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:48:"themes/admin_simpleboot3/admin\theme\design.html";i:1539085300;s:87:"E:\phpStudy\PHPTutorial\WWW\EdcForHx\public\themes\admin_simpleboot3\public\header.html";i:1539085300;}*/ ?>
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


    <link href="/EdcForHx/public/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/EdcForHx/public/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/EdcForHx/public/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
            ROOT: "/EdcForHx/public/",
            WEB_ROOT: "/EdcForHx/public/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/EdcForHx/public/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/EdcForHx/public/static/js/wind.js"></script>
    <script src="/EdcForHx/public/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
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
<style>
    html, body {
        padding: 0;
        height: 100%;
        margin: 0;
        overflow: hidden;
    }

    #simulator, #setting-iframe {
        width: 100%;
        height: 100%;
    }

    .setting-panel-wrap {
        position: fixed;
        left: 0;
        bottom: 0;
        top: 0;
        width: 350px;
        border-right: 1px solid #eee;
        display: none;
        background: #fff;
    }

    #setting-iframe-wrap {
        position: absolute;
        top: 0;
        bottom: 50px;
        right: 0;
        left: 0;
    }

    .setting-panel-wrap .panel {
    }

    .setting-panel-wrap .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 50px;
        border-top: 1px solid #eee;
        padding: 8px;
    }

    #close-setting-panel {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 99;
        font-size: 18px;
    }

    #show-setting-panel {
        position: fixed;
        top: 30px;
        left: 30px;
        z-index: 99;
        font-size: 20px;
        line-height: 50px;
        width: 50px;
        border: 1px solid #eee;
        text-align: center;
        border-radius: 50%;
        cursor: pointer;
        background: #fff;
    }

    #update-theme-btn {
        position: fixed;
        top: 30px;
        right: 30px;
        z-index: 99;
        font-size: 20px;
        line-height: 50px;
        width: 50px;
        border: 1px solid #eee;
        text-align: center;
        border-radius: 50%;
        cursor: pointer;
        background: #fff;
    }

    #update-theme-btn:focus {
        outline: none;
    }

    #show-setting-panel:hover {
        background: #eee;
        border-color: #ddd;
    }

    #think_page_trace {
        display: none !important;
    }

    #think_page_trace_open {
        display: none !important;
    }
</style>
</head>
<body>
<a id="show-setting-panel" title="编辑当前页" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
<a id="update-theme-btn" title="刷新当前页" data-toggle="tooltip"><i class="fa fa-refresh"></i></a>
<div class="setting-panel-wrap">
    <a href="javascript:;" id="close-setting-panel"><i class="fa fa-close"></i></a>
    <div id="setting-iframe-wrap">
        <iframe frameborder="0" id="setting-iframe"></iframe>
    </div>
    <div class="footer text-center">
        <a id="save-btn" class="btn btn-primary">保存</a>
    </div>
</div>
<iframe src="/?_design_theme=<?php echo input('param.theme'); ?>" frameborder="0" id="simulator"></iframe>
<script src="/EdcForHx/public/static/js/admin.js"></script>
<script>
    var simulator            = $('#simulator').get(0).contentWindow;
    var $simulator           = $(simulator);
    var $settingIframe       = $('#setting-iframe');
    var simulatorNeedRefresh = true;

    $('#update-theme-btn').click(function () {
        simulator.location.reload(true);
    });


    $('#save-btn').click(function () {
        $settingIframe.get(0).contentWindow.confirm();
    });

    $('#close-setting-panel').click(function () {
        hideSettingPanel();
    });

    $('#show-setting-panel').click(function () {
        showSettingPanel();
    });

    function hideSettingPanel() {
        $('.setting-panel-wrap').fadeOut(function () {
            $('#show-setting-panel').show();
        });
    }

    function showSettingPanel() {
        $('.setting-panel-wrap').fadeIn();
        $('#show-setting-panel').hide();
    }

    function showDesignBtn() {
        if (!$('.setting-panel-wrap').is(':visible')) {
            $('#show-setting-panel').show();
        }

    }

    function hideDesignBtn() {
        $('.setting-panel-wrap').hide();
        $('#show-setting-panel').hide();
    }

    function simulatorRefresh() {
        if (simulatorNeedRefresh) {
            $settingIframe.attr('src', "<?php echo url('Theme/fileSetting'); ?>?theme=<?php echo input('param.theme'); ?>&file=" + simulator._themeFile);
            $simulator.load(function () {
                $(simulator.document).on('click', 'a', function () {
                    var target = $(this).attr('target');
                    var href   = $(this).attr('href');
                    if (target == '_blank' && href.indexOf('http') < 0) {
                        simulator.location.href = href;
                        return false;
                    }
                });
            });
        }

        simulatorNeedRefresh = true;
    }


    function afterSaveSetting() {
        simulatorNeedRefresh = false;
        simulator.location.reload();
    }


</script>
</body>
</html>