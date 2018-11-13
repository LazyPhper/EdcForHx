<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"themes/admin_simpleboot3/admin\project\see.html";i:1540550260;s:72:"G:\PHPTutorial\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1540550792;}*/ ?>
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
<style type="text/css">
	.div_title{background: #ecf0f1;height: 35px;line-height: 35px;font-family: "Microsoft YaHei", "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: medium;text-align: center}
	.div_input{margin-top: 2%;margin-left:5%;height: 35px;line-height: 35px;font-family: "Microsoft YaHei", "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: medium;text-align: left}
	.select_div{height:auto;margin-left: 8%;margin-top: 5px;}
	.div_select{margin-top: 2%;margin-left:5%;height: auto;font-family: "Microsoft YaHei", "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: medium;text-align: left}
	.option_div{margin-top: 8px;}
	.table_border{border: 1px solid #95a5a6;margin-top: 8px;}
	.td_border{border: 1px solid #95a5a6;height:35px;width:150px;text-align: center}
	.input-normal{width: 250px;}

</style>
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li ><a href="<?php echo url('project/edit',['id'=>$project_id]); ?>">项目基本信息</a></li>
			<li class="active"><a href="">项目CRF</a></li>
		</ul>
		<form action="<?php echo url('project/edceditPost'); ?>" method="post" class="form-horizontal js-ajax-form margin-top-20">
			<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
			<!--循环事件-->
			<?php if(is_array($result) || $result instanceof \think\Collection || $result instanceof \think\Paginator): if( count($result)==0 ) : echo "" ;else: foreach($result as $k=>$v): ?>
				<!--标题-->
				<?php
					if($v['event_type']=='title')
					{
				?>
				<div class="div_title"><?php echo $v['event_desc']; ?></div>
				<?php
					}
				?>
				<!--填空-->
				<?php
					if($v['event_type']=='input')
					{

						if($v['event_type_t']=='fill'){
						?>
						<div class="div_input"><?php echo $v['event_desc']; ?>&nbsp;&nbsp;&nbsp;<input class='input-normal' name="" type="text" value="" ></div>
				<?php
						}elseif($v['event_type_t']=='date'){
						?>
						<div class="div_input"><?php echo $v['event_desc']; ?>&nbsp;&nbsp;&nbsp;<input class="input-normal js-date"   type="text" name="" value="<?php echo date('Y-m-d',time()); ?>" ></div>
				<?php
						}elseif($v['event_type_t']=='desc'){
						?>
						<div class="div_input"><span class="form-required">*</span><?php echo $v['event_desc']; ?></div>
				<?php
						}
					}
				?>

				<!--选择-->

				<?php if($v['event_type']=='select')
					 {

					  	$select=json_decode($v['event_desc'],true);
					  	?>
						<div class="div_select">
							<span><?php echo $select['name']; ?></span>
							<div class="select_div">
								<?php if(is_array($select['option']) || $select['option'] instanceof \think\Collection || $select['option'] instanceof \think\Paginator): if( count($select['option'])==0 ) : echo "" ;else: foreach($select['option'] as $select_k=>$sel): ?>
									<div class="option_div"><span><?php echo $letter[$select_k]; ?></span>:&nbsp;&nbsp;&nbsp;<input type="<?php echo $v['event_type_t']; ?>" name="radio-1">&nbsp;<span class="select_input"><?php echo $sel; ?></span></div>
								<?php endforeach; endif; else: echo "" ;endif; ?>


							</div>
						</div>

				<?php
					  }
				?>

				<!--表格-->
				<?php if($v['event_type']=='table')
						{
							$table=json_decode($v['event_desc'],true);
				?>

						<div class="div_select">
							<span><?php echo $table['name']; ?></span>
							<table class="table_border" id="crf">
								<tr>
									<?php if(is_array($table['desc']) || $table['desc'] instanceof \think\Collection || $table['desc'] instanceof \think\Paginator): if( count($table['desc'])==0 ) : echo "" ;else: foreach($table['desc'] as $table_k=>$tab): ?>
									<td class="td_border"><?php echo $tab; ?></td>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</tr>
								<tr id="crf-tr">
									<?php if(is_array($table['type']) || $table['type'] instanceof \think\Collection || $table['type'] instanceof \think\Paginator): if( count($table['type'])==0 ) : echo "" ;else: foreach($table['type'] as $table_k=>$tab_t): if($tab_t=='text')
												{
												?>
												<td class="td_border"><input type="text" class="input-normal" name="" value=""></td>
										<?php
												}elseif($tab_t=='date'){
												?>
												<td class="td_border"><input class="input-normal  js-date" type="text"  name="" value="<?php echo date('Y-m-d',time()); ?>"></td>
										<?php
												}elseif($tab_t=='radio_or'){
												?>
												<td class="td_border"><input type="radio" name="" value="">是&nbsp;&nbsp;<input type="radio" name="" value="">否</td>
										<?php
												}else{
												?>
												<td class="td_border"><input type="text" class="input-normal" name="" value=""></td>
										<?php
												}
												endforeach; endif; else: echo "" ;endif; ?>

								</tr>
							</table>
							<a class="btn btn-primary" href="javascript:;" onclick='crfAddTr()'>追加</a>

						</div>

				<?php
					}
				endforeach; endif; else: echo "" ;endif; ?>


    </form>
		<div class="form-group" style="margin-top: 5%">
			<div class="col-sm-offset-2 col-sm-10">
				<a class="btn btn-danger" href="<?php echo url('project/edcedit',['project_id'=>$project_id]); ?>">继续编辑CRF</a>

			</div>
		</div>
	</div>

	<script src="/hx/public/static/js/admin.js"></script>
</body>
</html>
<script>
	//删除tr
	function crfDel(k) {
        $(k).parent().parent().remove();
    }

	/*对表格增加tr*/
	function crfAddTr(table_id) {
	    var tab=table_id;
	    var hhtml=$("#"+tab+'-tr').html();
		var append_hhtml='<tr>'+hhtml+
            '<td class="td_last"><span class="btn btn-danger" onclick="crfDel(this)">X</span></td>'+
            '</tr>';
		$("#"+tab).append(append_hhtml);

    }

    /*字母增加*/
	function selectSort(num)
	{
	    var new_array=new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	    return new_array[num];

	}

</script>
