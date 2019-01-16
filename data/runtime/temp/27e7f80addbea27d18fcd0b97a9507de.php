<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"themes/admin_simpleboot3/admin\main\index.html";i:1547204452;s:69:"D:\phpStudy\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1547549958;}*/ ?>
 <link href="/hx/public/static/js/layui/css/layui.css" rel="stylesheet" type="text/css">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">联系方式</h3>
            </div>
            <div class="panel-body home-info">
                <ul class="list-unstyled">
                    <li>
                        <em>官网</em> <span><a href="http://www.thinkcmf.com" target="_blank">www.baidu.com</a></span>
                    </li>
                    <li><em>QQ</em> <span>1016122628</span></li>
                    <li><em>联系邮箱</em> <span>1016122628@qq.com</span></li>
                </ul>
            </div>
        </div>
   
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">系统通知</h3>
            </div>
            <div class="panel-body home-info">
                <ul class="list-unstyled">
                    <li>
                        <?php if($count>0){ ?>
                        <em>您有疑问未解答&nbsp;&nbsp;<a style='display:inline' class='btn btn-sm btn-danger' href="<?php echo url('admin/main/asklist'); ?>"><?php echo $count; ?></a></em>
                        <?php }else{ ?>
                             <em>尚未有疑问</em>
                        <?php } ?>                        
                    </li>

                     

                </ul>
            </div>

               <div class="panel-body home-info">
                <ul class="list-unstyled">
                   <li>
                        <?php if($count_ask>0){ ?>
                        <em>您有回复尚未查看&nbsp;&nbsp;<a style='display:inline' class='btn btn-sm btn-danger' href="<?php echo url('admin/main/answerlist'); ?>"><?php echo $count_ask; ?></a></em>
                        <?php }else{ ?>
                             <em>尚未有疑问</em>
                        <?php } ?>                        
                    </li>

                </ul>
            </div>

            <div class="panel-body home-info">
                <ul class="list-unstyled">
                   <li>
                        <?php if($count_gone>0){ ?>
                        <em>您有已结束疑问&nbsp;&nbsp;<a style='display:inline' class='btn btn-sm btn-default' href="#"><?php echo $count_gone; ?></a></em>
                        <?php }else{ ?>
                             <em>尚未有已结束</em>
                        <?php } ?>                        
                    </li>

                </ul>
            </div>


        </div>
<table class="layui-table">
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>受试者ID</th>
      <th>受试者姓名</th>
      <th>疑问状态</th>
      <th>中心名字</th>
      <th>项目名</th>
      <th>事件名称</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
        <tr>
          <td><?php echo $vo['user_sn']; ?></td>
          <td><?php echo $vo['user_login']; ?></td>
          <td>
            <?php if($vo['status']==1&&$vo['respone_status']==0){echo "<p style='color:red'>新增疑问</p>";} if($vo['status']==1&&$vo['respone_status']==1){echo "<p style='color:green'>新增回复</p>";} if($vo['status']==2){echo "<p style='color:#CCC'>已结束</p>";} ?>

          </td>
          <td><?php echo $vo['center_name']; ?></td>
          <td><?php echo $vo['project_name']; ?></td>
          <td><?php echo $vo['event_desc']; ?></td>
          <td>
             <a href="<?php echo url('admin/main/info',['id'=>$vo['ask_id']]); ?>" class="layui-btn">查看</a>
          </td>
        </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    
   
  </tbody>
</table>
<div class="pagination"><?php echo $page; ?></div>

   
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
<script src="/hx/public/static/js/layui/layui.js"></script>
<style>
    .home-info li em {
        float: left;
        width: 120px;
        font-style: normal;
        font-weight: bold;
    }

    .home-info ul {
        padding: 0;
        margin: 0;
    }

    .panel {
        margin-bottom: 0;
    }

    .grid-sizer {
        width: 10%;
    }

    .grid-item {
        margin-bottom: 5px;
        padding: 5px;
    }

    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        padding-left: 5px;
        padding-right: 5px;
        float: none;
    }

</style>
<?php 
    \think\Hook::listen('admin_before_head_end',$temp5c3e9417c7e48,null,false);
 ?>
</head>
<body>
<div class="wrap">

</div>
<script src="/hx/public/static/js/admin.js"></script>
<script src="/hx/public/static/js/layui/layui.js"></script>
<?php 
    $lang_set=defined('LANG_SET')?LANG_SET:'';
    $thinkcmf_version=defined('THINKCMF_VERSION')?THINKCMF_VERSION:'';
 ?>
<script>
    layui.use('form', function(){
          var form = layui.form;
          //各种基于事件的操作，下面会有进一步介绍
        });
    Wind.css('dragula');
    Wind.use('masonry', 'imagesloaded', 'dragula', function () {
        var $homeGrid = $('.home-grid').masonry({
            // set itemSelector so .grid-sizer is not used in layout
            itemSelector: '.grid-item',
            // use element for option
            columnWidth: '.grid-sizer',
            percentPosition: true,
            horizontalOrder: false,
            transitionDuration: 0
        });

        $homeGrid.masonry('on', 'layoutComplete', function (event, laidOutItems) {
        });


        $homeGrid.masonry();

        var containers = [];
        $('.home-grid .grid-item').each(function () {
            containers.push(this);
        });
        dragula(containers, {
            isContainer: function (el) {
                return false; // only elements in drake.containers will be taken into account
            },
            moves: function (el, source, handle, sibling) {
                return true; // elements are always draggable by default
            },
            accepts: function (el, target, source, sibling) {
                return true; // elements can be dropped in any of the `containers` by default
            },
            invalid: function (el, handle) {
                return false; // don't prevent any drags from initiating by default
            },
            direction: 'vertical',             // Y axis is considered when determining where an element would be dropped
            copy: false,                       // elements are moved by default, not copied
            copySortSource: false,             // elements in copy-source containers can be reordered
            revertOnSpill: false,              // spilling will put the element back where it was dragged from, if this is true
            removeOnSpill: false,              // spilling will `.remove` the element, if this is true
            mirrorContainer: document.body,    // set the element that gets mirror elements appended
            ignoreInputTextSelection: true     // allows users to select input text, see details below
        }).on('drop', function (el, target, source, sibling) {
            var $target          = $(target);
            var targetClasses    = $target.attr('class');
            var targetDataWidget = $target.data('widget');
            var targetDataSystem = $target.data('system');
            var $source          = $(source);
            var sourceClasses    = $source.attr('class');
            var sourceDataWidget = $source.data('widget');
            var sourceDataSystem = $source.data('system');
            $(source).append($(target).find('.dashboard-box').not('.gu-transit'));
            $(target).append(el);
            $target.attr('class', sourceClasses);
            $target.data('widget', sourceDataWidget);
            $target.data('system', sourceDataSystem);

            $source.attr('class', targetClasses);
            $source.data('widget', targetDataWidget);
            $source.data('system', targetDataSystem);
            $homeGrid.masonry();

            _widgetSort();
        }).on('shadow', function (el, container, source) {
            $homeGrid.masonry();
        });


    });

    function _widgetSort() {

        var widgets = [];
        $('.home-grid .grid-item').each(function () {
            var $this = $(this);

            widgets.push({
                name: $this.data('widget'),
                is_system: $this.data('system')
            });
        });

        $.ajax({
            url: "<?php echo url('main/dashboardWidget'); ?>",
            type: 'post',
            dataType: 'json',
            data: {widgets: widgets},
            success: function (data) {

            },
            error: function () {

            },
            complete: function () {

            }
        });
    }


</script>
<?php 
    \think\Hook::listen('admin_before_body_end',$temp5c3e9417c7e48,null,false);
 ?>
</body>
</html>