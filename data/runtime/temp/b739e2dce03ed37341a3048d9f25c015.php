<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:49:"themes/admin_simpleboot3/admin\user\user_crf.html";i:1543827645;s:69:"D:\phpStudy\WWW\hx\public\themes\admin_simpleboot3\public\header.html";i:1540550792;}*/ ?>
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
<script type="text/javascript">
    $(document).ready(function(e) {
        $(".tab li").click(function(){
            $(".tab li").eq($(this).index()).addClass("activ").siblings().removeClass("activ");
            $(".divv").hide().eq($(this).index()).show();
        })
    });
</script>
<style>
	/* 选项卡 */
	body {
		font: 12px/20px Open Sans,微软雅黑, Helvetica, Arial, sans-serif;
		background:#F9F9F9;
		margin:0;
		padding:0;
		color:#555555;
		min-width:1000px
	}
	a {
		color:#111111;
		text-decoration:none;
		-webkit-transition:color 0.2s linear;
		-moz-transition:color 0.2s linear;
		-o-transition:color 0.2s linear;
		transition:color 0.2s linear
	}
	a:focus , a:link, a:active { outline:none}
	a:hover { color:#F30}
	ol, ul, li{	list-style: none}
	*{margin:0;padding:0}
	html,body { margin:0; padding:0; height:100%}
	.table_card { width:100%; margin:0 auto;margin-top: 20px}
	.table_card .tab { height:37px; font-size:14px; border-bottom:1px #e1e1e1 solid}
	.table_card .tab li { float:left; height:36px; line-height:36px; padding:0 25px; margin-right:5px; background:#f0f0f0; border-top:1px #e1e1e1 solid; border-left:1px #e1e1e1 solid; border-right:1px #e1e1e1 solid;}
	.table_card .tab li:hover { height:37px; background:#fff; color:#333; cursor:pointer}
	.table_card .activ { height:37px !important; background:#fff !important; color:#333}
	.table_card .tabCon { background:#fff; padding:15px; border-bottom:1px #e1e1e1 solid; border-left:1px #e1e1e1 solid; border-right:1px #e1e1e1 solid;}
	.table_card .tabCon .off{ display:none}
	.table_card .tabCon .on { display:block}

	.newslist01 { font-size:14px; }
	.newslist01 li { line-height:36px;}
	.newslist01 li .ding { color:#F30; margin-left:5px}
	.newslist01 li .time { float:right; font-size:12px; color:#888}
	.div_title{background: #ecf0f1;margin-top:10px;height: 35px;line-height: 35px;font-family: "Microsoft YaHei", "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: medium;text-align: center}
	.div_input{margin-top: 1%;margin-left:5%;height: 35px;line-height: 35px;font-family: "Microsoft YaHei", "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: medium;text-align: left}
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
			<li ><a href="<?php echo url('user/project_info',['id'=>$project_id]); ?>">项目基本信息</a></li>
			<li class="active"><a href="">CRF录入</a></li>
		</ul>
		<!--# 选项卡 -->
		<div class="table_card">
			<ul class="tab">
				<?php if(is_array($result) || $result instanceof \think\Collection || $result instanceof \think\Paginator): if( count($result)==0 ) : echo "" ;else: foreach($result as $k=>$v): if($v['event_type']=='title'): if($k==0): ?>
					 	<li class="activ">
							<?php echo $v['event_desc']; ?>
					 	</li>
					 	<?php else: ?>
					 	<li><?php echo $v['event_desc']; ?></li>
					 <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
		
			</ul>
			<div class="tabCon">
				<?php if(is_array($crf_result) || $crf_result instanceof \think\Collection || $crf_result instanceof \think\Paginator): if( count($crf_result)==0 ) : echo "" ;else: foreach($crf_result as $k=>$value): ?>
				<div <?php if($k==1){echo "class='on divv'"; }else{ echo "class='off divv'";} ?>>
				<form action="" method="post" id='event-<?php echo $k; ?>' class="margin-top-20">
				<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
				<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
				<!--循环事件-->
				<!--标题-->
				<?php if(is_array($value) || $value instanceof \think\Collection || $value instanceof \think\Paginator): if( count($value)==0 ) : echo "" ;else: foreach($value as $kkk=>$v): 					if($v['event_type']=='title')
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
						if(!empty($user_crf))
						{
							$vv=$user_crf[$v['id']]['crf_desc'];

						}else{
							$vv='';
						}
						?>
						<div class="div_input"><?php echo $v['event_desc']; ?>&nbsp;&nbsp;&nbsp;<input class='input-normal' name="crf[<?php echo $v['id']; ?>]" type="text" value="<?php echo $vv; ?>" ></div>
				<?php
						}elseif($v['event_type_t']=='date'){
						if(!empty($user_crf))
						{
							$vv=$user_crf[$v['id']]['crf_desc'];
						}else{
							$vv='';
						}
						?>
						<div class="div_input"><?php echo $v['event_desc']; ?>&nbsp;&nbsp;&nbsp;<input class="input-normal js-date"   type="text" name="crf[<?php echo $v['id']; ?>]" value="<?php echo $vv; ?>" ></div>
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
									<div class="option_div"><span><?php echo $letter[$select_k];?></span>
										<?php if(isset($user_crf[$v['id']])){ $de=$user_crf[$v['id']]['crf_desc']; } if($v['event_type_t']=='radio'){ ?>

										<input type="<?php echo $v['event_type_t']; ?>" name="crf[<?php echo $v['id']; ?>]" <?php if(isset($de)){if($de==$letter[$select_k]){ echo 'checked';}} ?> value="<?php echo $letter[$select_k]; ?>">
										<?php  }else{ 
												if(isset($user_crf[$v['id']])){ $de=$user_crf[$v['id']]['crf_desc']; $dearray=json_decode($de,true); }else{ $dearray=array();}
											?>
										<input type="<?php echo $v['event_type_t']; ?>" name="crf[<?php echo $v['id']; ?>][]" <?php if(in_array($letter[$select_k], $dearray)){ echo 'checked';} ?> value="<?php echo $letter[$select_k]; ?>">
										<?php  } ?>
										<span class="select_input"><?php echo $sel; ?></span></div>
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
							<table class="table_border" id="crf-<?php echo $v['id']; ?>">
								<tr>
									<?php if(is_array($table['desc']) || $table['desc'] instanceof \think\Collection || $table['desc'] instanceof \think\Paginator): if( count($table['desc'])==0 ) : echo "" ;else: foreach($table['desc'] as $table_k=>$tab): ?>
									<td class="td_border"><?php echo $tab; ?></td>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</tr>
								<!--数据循环-->
								<?php if(!isset($user_crf[$v['id']])){ ?>
								<tr id="crf-<?php echo $v['id']; ?>-tr"  class="tr_num">
									<?php if(is_array($table['type']) || $table['type'] instanceof \think\Collection || $table['type'] instanceof \think\Paginator): if( count($table['type'])==0 ) : echo "" ;else: foreach($table['type'] as $table_k=>$tab_t): if($tab_t=='text')
												{
												?>
												<td class="td_border"><input type="text" class="input-normal" name="crf[<?php echo $v['id']; ?>][1][]" value=""></td>
										<?php
												}elseif($tab_t=='date'){
												?>
												<td class="td_border"><input class="input-normal  js-date" type="text"  name="crf[<?php echo $v['id']; ?>][1][]" value="<?php echo date('Y-m-d',time()); ?>"></td>
										<?php
												}elseif($tab_t=='radio_or'){
												?>
												<td class="td_border"><input type="radio" name="crf[<?php echo $v['id']; ?>][1][]" checked value="1"> 是&nbsp;&nbsp;<input type="radio" name="crf[<?php echo $v['id']; ?>][1][]" value="2">否</td>
										<?php
												}else{
												?>
												<td class="td_border"><input type="text" class="input-normal" name="crf[<?php echo $v['id']; ?>][1][]" value=""></td>
										<?php
												}
												endforeach; endif; else: echo "" ;endif; ?>
								</tr>
								<?php }else{
									if(isset($user_crf[$v['id']]))
									{
										$crf=$user_crf[$v['id']];
										$crf_desc=$crf['crf_desc'];
										$des=json_decode($crf_desc,true);
									}else{
										$des=array();
									}
									
									if(is_array($des) || $des instanceof \think\Collection || $des instanceof \think\Paginator): if( count($des)==0 ) : echo "" ;else: foreach($des as $kk=>$value): if($kk==1){ ?>
										<tr id="crf-<?php echo $v['id']; ?>-tr"  class="tr_num">
											<?php if(is_array($table['type']) || $table['type'] instanceof \think\Collection || $table['type'] instanceof \think\Paginator): if( count($table['type'])==0 ) : echo "" ;else: foreach($table['type'] as $table_k=>$tab_t): if(isset($value[$table_k])){ $dd=$value[$table_k]; }else{ $dd=''; }  if($tab_t=='text')
												{
												?>
												<td class="td_border"><input type="text" class="input-normal" name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" value="<?php echo $dd; ?>"></td>
												<?php
												}elseif($tab_t=='date'){
												?>
												<td class="td_border"><input class="input-normal  js-date" type="text"  name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" value="<?php echo $dd; ?>"></td>
												<?php
												}elseif($tab_t=='radio_or'){
												?>
												<td class="td_border"><input type="radio" name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" <?php if($dd==1){ echo 'checked';} ?> value="1"> 是&nbsp;&nbsp;<input type="radio" name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" <?php if($dd==2){ echo 'checked';} ?> value="2">否</td>
												<?php
												}else{
												?>
												<td class="td_border"><input type="text" class="input-normal" name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" value="<?php echo $dd; ?>"></td>
												<?php
												}
												endforeach; endif; else: echo "" ;endif; ?>
										</tr>
										<?php }else{ ?>
										<tr  class="tr_num">
											<?php if(is_array($table['type']) || $table['type'] instanceof \think\Collection || $table['type'] instanceof \think\Paginator): if( count($table['type'])==0 ) : echo "" ;else: foreach($table['type'] as $table_k=>$tab_t): if(isset($value[$table_k])){ $dd=$value[$table_k]; }else{ $dd=''; } if($tab_t=='text')
												{
												?>
												<td class="td_border"><input type="text" class="input-normal" name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" value="<?php echo $dd; ?>"></td>
												<?php
												}elseif($tab_t=='date'){
												?>
												<td class="td_border"><input class="input-normal  js-date" type="text"  name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" value="<?php echo $dd; ?>"></td>
												<?php
												}elseif($tab_t=='radio_or'){
												?>
												<td class="td_border"><input type="radio" name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" <?php if($dd==1){ echo 'checked';} ?> value="1"> 是&nbsp;&nbsp;<input type="radio" name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" <?php if($dd==2){ echo 'checked';} ?> value="2">否</td>
												<?php
												}else{
												?>
												<td class="td_border"><input type="text" class="input-normal" name="crf[<?php echo $v['id']; ?>][<?php echo $kk; ?>][]" value="<?php echo $dd; ?>"></td>
												<?php
												}
												endforeach; endif; else: echo "" ;endif; ?>
										</tr>

										<?php } endforeach; endif; else: echo "" ;endif; } ?>
							</table>
							<a class="btn btn-primary" href="javascript:;" onclick='crfAddTr("crf-<?php echo $v['id']; ?>","<?php echo $v['id']; ?>")'>追加</a>

						</div>
				<?php
					}
				endforeach; endif; else: echo "" ;endif; ?>

			
					<div class="form-group" style="margin-top: 5%">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-primary" onclick="postForm('event-<?php echo $k; ?>')"><?php echo lang('SAVE'); ?></button>
						</div>
					</div>
					</form>
				</div>

				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<!--#@ 选项卡 -->

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
	function crfAddTr(table_id,id) {
	    var tab=table_id;
	    var id=id;
	    var hhtml=$("#"+tab+'-tr').html();
		var append_hhtml='<tr class="tr_num">'+hhtml+
            '<td class="td_last"><span class="btn btn-danger" onclick="crfDel(this)">X</span></td>'+
            '</tr>';
		$("#"+tab).append(append_hhtml);
		
		//增加之后修改最后一个input的name
		var tr_num=$("#"+tab).find('.tr_num').length;
		var input_name="crf["+id+"]["+tr_num+"][]";
      	$("#"+tab+' tr:last input').attr('name',input_name);
    }

    /*字母增加*/
	function selectSort(num)
	{
	    var new_array=new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	    return new_array[num];

	}

	function postForm(formId)
	{
		var formData = $("#"+formId).serialize(); 
                //serialize() 方法通过序列化表单值，创建 URL 编码文本字符串,这个是jquery提供的方法  
                $.ajax({  
                    type:"post",  
                    url:"<?php echo url('admin/user/crfpost'); ?>",  
                    data:formData,//这里data传递过去的是序列化以后的字符串  
                    success:function(data){  
                       
                    }  
                });  

	}

</script>
